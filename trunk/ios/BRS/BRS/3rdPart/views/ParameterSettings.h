//
//  ParameterSettings.h
//  BRS
//
//  Created by cgx on 13-10-24.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#ifndef BRS_ParameterSettings_h
#define BRS_ParameterSettings_h

#define iPhone5 ([UIScreen instancesRespondToSelector:@selector(currentMode)] ? CGSizeEqualToSize(CGSizeMake(640, 1136), [[UIScreen mainScreen] currentMode].size) : NO)

#define IOS7 [[[UIDevice currentDevice]systemVersion] floatValue] >= 7.0 //判断是否是ios7以上的系统

#define IMAGE(imagePath) [UIImage imageWithContentsOfFile:[[NSBundle mainBundle] pathForResource:(imagePath) ofType:@"png"]]

#define WIDTH 320       //屏幕的宽度固定
#define HEIGHT 416      //iPhone4除去NAVBar的高度

#define NAVBARHEIGHT 44 //NAVBar的高度44

#define Resource @"resource"
#define Message @"message"
#define Config @"config"


#define Identifier1 @"TILLWIMM"//用户唯一码
#define Identifier2 @"ABCDEF"

#define StatusHeight (IOS7?20:0)


#endif


