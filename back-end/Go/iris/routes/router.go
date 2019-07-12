package routes

import (
	"blog/controllers/backend"
	"blog/service"
	"github.com/kataras/iris"
)

func RegisterRoutes(app *iris.Application) {
	app.Get("/api/captcha", backend.GetCaptcha)

	adminNeedAuth := app.Party("/api/admin", service.GetJWTHandler().Serve)

	//管理员组
	adminGroup := adminNeedAuth.Party("/")
	{
		//获取个人信息
		adminGroup.Get("/", backend.GetUserInfo)
		//修改个人信息
		adminGroup.Put("/", backend.UpdateInfo)
		//退出登录
		adminGroup.Post("/logout", backend.Logout)
		//修改密码
		adminGroup.Put("/password", backend.ResetPassword)
	}

	//分类组
	categoryGroup := adminNeedAuth.Party("/category")
	{
		//获取分类列表
		categoryGroup.Get("/", backend.GetCategoryList)
		//添加分类
		categoryGroup.Post("/", backend.AddCategory)
		//修改分类
		categoryGroup.Put("/", backend.UpdateCategory)
		//删除分类
		categoryGroup.Delete("/", backend.DeleteCategory)
	}

	//闲聊组
	chatGroup := adminNeedAuth.Party("/chat")
	{
		//获取闲聊列表
		chatGroup.Get("/", backend.GetChatList)
		//添加说说
		chatGroup.Post("/", backend.AddChat)
		//修改说说
		chatGroup.Put("/", backend.UpdateChat)
		//删除说说
		chatGroup.Delete("/", backend.DeleteChat)
	}

	adminNoAuth := app.Party("/api/admin")
	{
		//登录
		adminNoAuth.Post("/login", backend.Login)
	}
}
