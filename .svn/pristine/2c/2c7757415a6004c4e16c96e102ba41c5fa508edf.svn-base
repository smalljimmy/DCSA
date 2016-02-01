//
//  LanguageController.m
//  SolarMAN
//
//  Created by cgx on 13-3-16.
//
//

#import "LanguageController.h"

static NSBundle *bundle = nil;

@implementation LanguageController

+ (NSString*)getPreferredLanguage
{
    
    NSUserDefaults *defaultLauage = [NSUserDefaults standardUserDefaults];
    NSArray* languages = [defaultLauage objectForKey:@"AppleLanguages"];
    NSString* preferredLang = [languages objectAtIndex:0];
    
    //NSLog(@"Preferred Language:%@", preferredLang);
    
    return preferredLang;
}

+(void)setLanguage
{
    NSString *path=nil;
    NSString *languageClassity=[[NSUserDefaults standardUserDefaults]objectForKey:@"languageChoose"];
    
    if (languageClassity)
    {
        path = [[NSBundle mainBundle] pathForResource:languageClassity ofType:@"lproj"];
       
    }
    else
    {
        if ([[LanguageController getPreferredLanguage] isEqualToString:@"zh-Hans"] || [[LanguageController getPreferredLanguage] isEqualToString:@"en"] || [[LanguageController getPreferredLanguage] isEqualToString:@""])
        {
            //获取系统语言
            [[NSUserDefaults standardUserDefaults]setObject:[LanguageController getPreferredLanguage] forKey:@"languageChoose"];//选择中文
            path = [[NSBundle mainBundle] pathForResource:[LanguageController getPreferredLanguage] ofType:@"lproj"];
        }
        else
        {
            [[NSUserDefaults standardUserDefaults]setObject:@"en" forKey:@"languageChoose"];//选择中文
            path = [[NSBundle mainBundle] pathForResource:@"en" ofType:@"lproj"];
        }

    }
    
    bundle = [[NSBundle bundleWithPath:path] retain];
  
}


+(NSString *)get:(NSString *)key alter:(NSString *)alternate
{
    return [bundle localizedStringForKey:key value:alternate table:nil];
}


@end
