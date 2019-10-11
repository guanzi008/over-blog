package models

import (
	"blog/database"
	"blog/helper"
	"blog/service"
	"github.com/oschwald/geoip2-golang"
	"net"
	"time"
)

type User struct {
	ID            *int64 `json:"id" validate:"gt=0"`
	Type          uint   `json:"type"`
	Name          string `json:"name"`
	OpenID        string `json:"openid" gorm:"column:openid"`
	AccessToken   string `json:"access_token"`
	LastLoginIp   string `json:"last_login_ip"`
	RememberToken string `json:"remember_token"`
	LoginTimes    *int64 `json:"login_times"`
	IsAdmin       *int8  `json:"is_admin" validate:"oneof=0 1"`
	Email         string `json:"email"`
	Avatar        string `json:"avatar"`
	CreatedUnix   int64  `json:"created_unix" gorm:"column:created_at"`
	UpdatedUnix   int64  `json:"updated_unix" gorm:"column:updated_at"`
	CreatedAt     string `json:"created_at" gorm:"-"`
	UpdatedAt     string `json:"updated_at" gorm:"-"`
}

func (User) TableName() string {
	return "user"
}

func (this *User) AfterFind() {
	this.CreatedAt = helper.GetDateTime(this.CreatedUnix, helper.YMDHIS)
	this.UpdatedAt = helper.GetDateTime(this.UpdatedUnix, helper.YMDHIS)
	this.LastLoginIp = getAddress(this.LastLoginIp)
}

var geoDb = getGeoDb()

func getGeoDb() *geoip2.Reader {
	db, err := geoip2.Open("./geo.mmdb")
	if err != nil {
		service.Log.Error(err.Error())
		return nil
	}
	return db
}

/**
获取IP对应的地址
*/
func getAddress(ip string) string {
	if geoDb == nil {
		return "未知地方"
	}
	right_ip := net.ParseIP(ip)
	record, err := geoDb.City(right_ip)
	if err != nil {
		service.Log.Error(err.Error())
		return "未知地方"
	}
	var city, country string
	iso_code := record.Country.IsoCode
	if iso_code == "TW" {
		country = "中国"
		city = "台湾"
	} else if iso_code == "HK" {
		country = "中国"
		city = "香港"
	} else if iso_code == "MO" {
		country = "中国"
		city = "澳门"
	} else {
		city = record.City.Names["zh-CN"]
		country = record.Country.Names["zh-CN"]
	}
	province := record.Subdivisions[0].Names["zh-CN"]
	return country + province + city
}

/**
获取用户列表
*/
func (this User) GetUserList(pageNum, pageSize int64, search string) map[string]interface{} {
	user := []User{}
	var db = database.Db.Table("user")
	if search != "" {
		db = db.Where("name like ?", "%"+search+"%").Or("email like ?", "%"+search+"%")
	}
	var total int64 = 0
	db.Count(&total)
	db.Order("created_at desc").Offset((pageNum - 1) * pageSize).Limit(pageSize).Find(&user)
	data := make(map[string]interface{})
	data["total"] = total
	data["list"] = user
	return data
}

/**
删除用户
*/
func (this User) DeleteUser() bool {
	res := database.Db.Delete(&this)
	if res.Error != nil {
		return false
	}
	return true
}

/**
修改用户信息
*/
func (this User) UpdateUser() bool {
	now := time.Now().Unix()
	data := map[string]interface{}{
		"is_admin":   *this.IsAdmin,
		"updated_at": now,
	}
	result := database.Db.Model(&this).Updates(data)
	if result.Error != nil {
		return false
	}
	return true
}
