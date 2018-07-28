本项目fork自FeehiCMS，主要用的是它提供的站点/RBAC及后台模板

然后再根据我自己的想法，将公用的部分提取到common下

也没做migrate，直接导入yii2adv.sql即可

$ php ./init --env=Development #初始化yii2框架，线上环境请使用--env=Production

后台默认用户名：admin

密码：123456

目录结构

common\components       放置公共模块

common\vendor           放置第三方接口

common\modules          存放子功能模块

		models   数据库Model
		
		base     接口层，主要是定义一些interface
		
		data     数据层，主要是操作DB及REDIS，对上层提供透明的数据输出
		
		service  业务逻辑层，主要业务逻辑放这里，供不同站点调用，方便复用
		
		views    视图层,如站点间视图复用，可放这里，如不复用，则放在各站点