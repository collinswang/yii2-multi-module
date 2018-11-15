<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-03 00:15
 */
namespace frontend\models;

use common\helpers\FamilyTree;
use common\helpers\FileDependencyHelper;
use common\models\Menu as CommonMenu;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class Menu extends CommonMenu
{
    /**
     * 生成后台首页菜单html
     *
     * @return string
     */
    public static function getFrontendMenu()
    {
        $model = new self();
        $menus = $model->find()->where(['is_display' => self::DISPLAY_YES, 'type' => self::FRONTEND_TYPE])->orderBy("sort asc")->asArray()->all();
        if( !in_array( yii::$app->getUser()->getId(), [] ) ) {
            $newMenu = [];
            foreach ($menus as $menu) {
                $url = $menu['url'];
                if( strpos($url, '/') !== 0 ) $url = '/' . $url;
                $url = $url . ':GET';
                $menu = self::getAncectorsByMenuId($menu['id']) + [$menu];
                $newMenu = array_merge($newMenu, $menu );
            }

            $menus = [];
            foreach ($newMenu as $v){
                $menus[$v['id']] = $v;
            }
            ArrayHelper::multisort($menus, 'sort', SORT_ASC);
        }

        $lis = '';
        foreach ($menus as $menu) {
            if ($menu['parent_id'] != 0) {
                continue;
            }
            $subMenu = self::_getBackendSubMenu($menus, $menu['id'], '2');
            $menu['icon'] = $menu['icon'] ? $menu['icon'] : 'fa-desktop';
            $menu['url'] = self::generateUrl($menu);
            $arrow = '';
            $class = 'class="J_menuItem"';
            if ($subMenu != '') {
                $arrow = ' arrow';
                $class = '';
            }
            $menu_name = yii::t('menu', $menu['name']);
            $lis .= <<<EOF
                    <li>
                        <a {$class} href="{$menu['url']}">
                            <i class="fa {$menu['icon']}"></i>
                            <span class="nav-label">{$menu_name}</span>
                            <span class="fa {$arrow}"></span>
                        </a>
                        $subMenu
                    </li>
EOF;
        }
        return $lis;
    }

    private static function _getBackendSubMenu($menus, $cur_id, $times)
    {
        $array = ['2' => 'second', '3' => 'third', '4' => 'fourth', '5' => 'fifth'];
        $level = $array[$times];
        $collapse = '';
        if ($times > 2) {
            $collapse = "collapse";
        }
        $subMenu = "<ul class='nav nav-{$level}-level {$collapse}'>";
        $times++;
        static $i = 1;
        foreach ($menus as $menu) {
            if ($menu['parent_id'] != $cur_id) {
                continue;
            }
            $subsubmenu = self::_getBackendSubMenu($menus, $menu['id'], $times);
            $url = $menu['url'] = self::generateUrl($menu);
            if ($subsubmenu == '') {
                $arrow = '';
            } else {
                $arrow = '<span class="fa arrow"></span>';
            }
            $menu_name = yii::t('menu', $menu['name']);
            $subMenu .= <<<EOF

                            <li>
                                <a class="J_menuItem" href="$url" data-index="$i">{$menu_name}{$arrow}</a>
                            $subsubmenu
                            </li>

EOF;
            $i++;
        }
        if ($subMenu != "<ul class='nav nav-{$level}-level {$collapse}'>") {
            return $subMenu . "</ul>";
        } else {
            return "";
        }

    }

    private static function generateUrl($menu)
    {
        if ($menu['url'] === '') {
            return '';
        } else {
            if ($menu['is_absolute_url'] == 1) {
                return $menu['url'];
            } else {
                return Url::to([$menu['url']]);
            }
        }
    }

    /**
     * 根据menu id获取祖先菜单
     *
     * @param string $id 菜单id
     * @return array
     */
    public static function getAncectorsByMenuId($id)
    {
        $menus = self::_getMenus(self::BACKEND_TYPE);
        $familyTree = new FamilyTree($menus);
        return $familyTree->getAncectors($id);
    }

    /**
     * 根据menu id获取子孙菜单
     *
     * @param string $id 菜单id
     * @return array
     */
    public static function getDescendantsByMenuId($id)
    {
        $menus = self::_getMenus(self::BACKEND_TYPE);
        $familyTree = new FamilyTree($menus);
        return $familyTree->getDescendants($id);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->removeBackendMenuCache();
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        parent::afterDelete();
        $this->removeBackendMenuCache();
    }

    public function removeBackendMenuCache()
    {
        $object = yii::createObject([
            'class' => FileDependencyHelper::className(),
            'fileName' => 'frontend_menu.txt',
        ]);
        $object->updateFile();
    }
}