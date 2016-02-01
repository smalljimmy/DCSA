//
//  LanguageController.h
//  SolarMAN
//
//  Created by cgx on 13-3-16.
//
//

#import <Foundation/Foundation.h>



@interface LanguageController : NSObject
{
  
}

+(void)setLanguage;//设置本地语言种类
+(NSString *)get:(NSString *)key alter:(NSString *)alternate;//语言显示转换

@end
