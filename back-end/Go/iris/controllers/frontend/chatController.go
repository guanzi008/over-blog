package frontend

import (
	"blog/database"
	"blog/models"
	"blog/service"
	template "blog/views"
	"github.com/kataras/iris"
	"bytes"
)

/**
说说页面
 */
func GetChatPage(ctx iris.Context) {
	chats := []models.Chat{}
	left_chat, right_chat := []models.Chat{}, []models.Chat{}
	database.Db.Table("chat").Where("is_show = ?", 1).Order("created_at desc").Find(&chats)
	if len(chats) > 0 {
		for k, value := range chats {
			if k%2 == 0 {
				left_chat = append(left_chat, value)
			} else {
				right_chat = append(right_chat, value)
			}
		}
	}
	buffer := new(bytes.Buffer)
	template.ChatPage(left_chat,right_chat,buffer)
	_, err := ctx.Write(buffer.Bytes())
	if err != nil {
		service.Log.Error(err.Error())
		ctx.StatusCode(iris.StatusInternalServerError)
		ctx.WriteString("出错啦...")
	}
}