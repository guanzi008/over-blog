package backend

import (
	"blog/models"
	"blog/service"
	"github.com/kataras/iris"
)

/**
获取说说列表
*/
func GetChatList(ctx iris.Context) {
	pageNum := ctx.URLParamInt64Default("pageNum", 1)
	pageSize := ctx.URLParamInt64Default("pageSize", 10)
	list := models.GetChatList(pageNum, pageSize)
	if len(list) > 0 {
		response.RenderSuccess(ctx, "获取说说列表成功", list)
		return
	}
	response.RenderError(ctx, "暂无说说列表数据", nil)
}

/**
添加说说
*/
func AddChat(ctx iris.Context) {
	chat := models.Chat{}
	err := ctx.ReadJSON(&chat)
	if err != nil {
		response.RenderError(ctx, "参数错误！", nil)
		return
	}
	validates := []service.BlogValidate{
		{chat.IsShow, "required,oneof=0 1", "说说是否显示值错误！"},
		{chat.Content, "required,gte=2,lte=255", "说说内容在2到255个字符之间！"},
	}
	err = service.ValidateField(validates)
	if err != nil {
		response.RenderError(ctx, err.Error(), nil)
		return
	}
	res := models.AddChat(&chat)
	if !res {
		response.RenderError(ctx, "添加说说失败，请稍后再试！", nil)
		return
	}
	response.RenderSuccess(ctx, "添加说说成功！", nil)
}

/**
修改说说
*/
func UpdateChat(ctx iris.Context) {
	chat := models.Chat{}
	err := ctx.ReadJSON(&chat)
	if err != nil {
		response.RenderError(ctx, "参数错误！", nil)
		return
	}
	validates := []service.BlogValidate{
		{chat.ID, "required,gt=0", "说说ID错误！"},
		{chat.IsShow, "required,oneof=0 1", "说说是否显示值错误！"},
		{chat.Content, "required,gte=2,lte=255", "说说内容在2到255个字符之间！"},
	}
	err = service.ValidateField(validates)
	if err != nil {
		response.RenderError(ctx, err.Error(), nil)
		return
	}
	res := models.UpdateChat(&chat)
	if !res {
		response.RenderError(ctx, "修改说说失败，请稍后再试！", nil)
		return
	}
	response.RenderSuccess(ctx, "修改说说成功！", nil)
}

/**
删除说说
*/
func DeleteChat(ctx iris.Context) {
	chat := models.Chat{}
	err := ctx.ReadJSON(&chat)
	if err != nil {
		response.RenderError(ctx, "参数错误！", nil)
		return
	}
	validates := []service.BlogValidate{
		{chat.ID, "required,gt=0", "说说ID错误！"},
	}
	err = service.ValidateField(validates)
	if err != nil {
		response.RenderError(ctx, err.Error(), nil)
		return
	}
	res := models.DeleteChat(&chat)
	if !res {
		response.RenderError(ctx, "删除说说失败，请稍后再试！", nil)
		return
	}
	response.RenderSuccess(ctx, "删除说说成功！", nil)
}