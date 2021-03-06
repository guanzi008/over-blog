## PHP版本运行环境要求

- Nginx 1.8+
- PHP 7.2+
- MySQL 5.7+
- Redis 3.0+
- node.js 8.0+

### 说明
> 下面的操作是基于Laravel版本来进行的，微信小程序需要自己去编写小程序代码实现小程序登录，具体可以参考我这篇文章: [微信小程序实现微信扫码登录](https://www.ohdata.top/article/19)

### 安装

1. git clone https://github.com/hxfighting/over-blog.git -b 3.0
2. 发布配置文件 `cd over-blog/back-end/PHP/laravel && cp .env.example .env`,然后将.env中的配置项填写完整
3. 安装依赖 `composer install`
4. 生成APP_KEY `/over-blog/back-end/PHP/laravel/php artisan key:g`
5. 生成JWT的key `/over-blog/back-end/PHP/laravel/php artisan jwt:s`
6. 更新ip `/over-blog/back-end/PHP/laravel/php artisan geoip:update`
7. 生成数据库数据表 `/over-blog/back-end/PHP/laravel/php artisan migrate`


### 后台管理系统

1. `cd over-blog/front-end/blog_admin && npm install`
2. 修改over-blog/front-end/blog_admin/src/config 中的index.js文件配置
3. `npm run dev`

### 扩展包使用情况


| **扩展包** | **一句话描述** | **本项目应用场景** |
| ---- | ---- | ---- | 
| [overtrue/easy-sms](https://github.com/overtrue/easy-sms) | 多网关短信发送组件 | 发送短信 |
| [barryvdh/laravel-cors](https://github.com/barryvdh/laravel-cors) | laravel跨域包 | 处理api接口跨域以及微信小程序登录跨域 |
| [overtrue/laravel-filesystem-qiniu](https://github.com/overtrue/laravel-filesystem-qiniu) | 七牛 CDN SDK | 各种图片存储 |
| [mews/captcha](https://github.com/mewebstudio/captcha) | laravel验证码包 | 后台登录验证码 |
| [overtrue/laravel-lang](https://github.com/overtrue/laravel-lang) | Laravel 多语言 | 报错信息本地化 |
| [overtrue/wechat](https://github.com/overtrue/wechat) | 微信 SDK | 小程序相关 |
| [overtrue/laravel-socialite](https://github.com/overtrue/laravel-socialite) | 社交登录组件 | 用户使用第三方登录 |
| [propaganistas/laravel-phone](https://github.com/Propaganistas/Laravel-Phone) | Laravel手机号验证包 | 后台手机号验证 |
| [tymon/jwt-auth](https://github.com/tymondesigns/jwt-auth) | Laravel JWT包 | 用于api的jwt认证 |
| [watson/rememberable](https://github.com/dwightwatson/rememberable) | Laravel 5 query cache | 用于缓存模型数据 |
| [guzzlehttp/guzzle](https://github.com/guzzle/guzzle) | HTTP 请求套件 | 我也记不得，反正就是要用  |
| [predis/predis](https://github.com/nrk/predis.git) | Redis 官方首推的 PHP 客户端开发包 | 缓存驱动 Redis 基础扩展包 |
| [sentry/sentry-laravel](https://github.com/getsentry/sentry-laravel) | Sentry 报错监控 | 监控系统错误 |
| [tucker-eric/eloquentfilter](https://github.com/tucker-eric/eloquentfilter) | 模型字段过滤 | 接口字段过滤 |
| [torann/geoip](https://github.com/Torann/laravel-geoip) | IP地址解析 | 用户IP地址解析 |
| [laravel/telescope](https://github.com/laravel/telescope) | Laravel 调试面板 | 调试 |


### 自定义 Artisan 命令

| 命令行名字 | 说明 | Cron | 代码调用 |
| --- | --- | --- | --- |
| `sms:send` |  发送短信 | 无 | 无 |
| `index:view` |  更新首页浏览统计 | 无 | 无 |

## golang版本说明

> golang版本要大于等于go1.11,GO111MODULE="on"

### 说明
> golang版本基于框架[iris](https://github.com/kataras/iris),如果不熟悉的同学可以去了解下。

### 安装

> 安装请在gopath以外的目录下安装

1. git clone https://github.com/hxfighting/over-blog.git -b 3.0
2. cd over-blog && cp config.toml.example config.toml，然后把config.toml中的配置项填写完整
3. 运行命令：go run main.go -config=".",注意：config参数写你的config.toml的目录地址，开发环境用.就可以了

### 扩展包使用情况


| **扩展包** | **一句话描述** | **本项目应用场景** |
| ---- | ---- | ---- | 
| [aliyun/alibaba-cloud-sdk-go](https://github.com/aliyun/alibaba-cloud-sdk-go) | 阿里云官方sdk | 发送短信 |
| [jinzhu/gorm](https://github.com/jinzhu/gorm) | orm包 | mysql orm |
| [dgrijalva/jwt-go](https://github.com/dgrijalva/jwt-go) | jwt | api token |
| [go-redis/redis](https://github.com/go-redis/redis) | redis client | redis连接 |
| [json-iterator/go](https://github.com/json-iterator/go) | 更快的json 序列化 | json数据序列化 |
| [mojocn/base64Captcha](https://github.com/mojocn/base64Captcha) | 验证码 | 后台接口登录的验证码 |
| [mitchellh/mapstructure](https://github.com/mitchellh/mapstructure) | map转换为struct | api接收指定数据为map，然后转换为对应的struct |
| [pelletier/go-toml](https://github.com/pelletier/go-toml) | toml文件读取 | 配置文件读取 |
| [gopkg.in/gomail.v2](https://github.com/go-gomail/gomail/tree/v2) | 邮件发送包 | 邮件发送 |
| [tidwall/gjson](https://github.com/tidwall/gjson) | json数据提取包 | 提取json中需要的数据 |
| [shiyanhui/hero](https://github.com/shiyanhui/hero) | golang模板引擎 | 用于前端页面的渲染  |
| [qiniu/api.v7](https://github.com/qiniu/api.v7) | 七牛官方SDK | 图片上传 |
| [oschwald/geoip2-golang](https://github.com/oschwald/geoip2-golang) | ip地址解析 | 用户ip地址解析 |
| [go-playground/validator](https://github.com/go-playground/validator) | struct参数效验 | 接口参数效验 |
| [getsentry/sentry-go](https://github.com/getsentry/sentry-go) | sentry异常报告 | 程序异常报告 |


### License 
MIT
