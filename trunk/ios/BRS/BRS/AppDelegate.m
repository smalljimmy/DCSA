//
//  AppDelegate.m
//  BRS
//
//  Created by cgx on 13-10-15.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import "AppDelegate.h"

@implementation AppDelegate
@synthesize configDic;
@synthesize baseUrl;
@synthesize updateTitle;
@synthesize updateBanner;
@synthesize token;
@synthesize push;

- (void)dealloc
{
    [_window release];
    [super dealloc];
}
/*
 //消息推送分类情况
 //1.程序未启动(也不在后台)。点击通知栏里的消息会触发以下方法
 - (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions
 {
 }
 可在这个方法里处理通知，代码如下：
 NSDictionary* pushNotification = [launchOptions objectForKey:UIApplicationLaunchOptionsRemoteNotificationKey];
 
 2.程序运行中(包括在后台)，点击通知栏里的通知，会触发以下方法
 
 -(void)application:(UIApplication *)application didReceiveRemoteNotification:(NSDictionary *)userInfo
 {
 }
 
 3.如果用户点击桌面app的图标打开程序，只会触发这个方法
 - (void)applicationDidBecomeActive:(UIApplication *)application
 这时候是没办法得到推送的通知的。
 */



- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions
{
    self.window = [[[UIWindow alloc] initWithFrame:[[UIScreen mainScreen] bounds]] autorelease];
    // Override point for customization after application launch.
    self.window.backgroundColor = [UIColor whiteColor];
    
    //推送设置
    [[UIApplication sharedApplication] registerForRemoteNotificationTypes:
     (UIRemoteNotificationTypeBadge | UIRemoteNotificationTypeSound | UIRemoteNotificationTypeAlert)];

    [application setApplicationIconBadgeNumber:0];
    
    RootViewController *root=[[RootViewController alloc]init];
    CustomNavigationController *navRoot=[[CustomNavigationController alloc] initWithRootViewController:root];
    
    self.window.rootViewController = navRoot;
    
    NSDictionary *pushNotification = [launchOptions objectForKey:UIApplicationLaunchOptionsRemoteNotificationKey];
    if (pushNotification)
    {
        //NSLog(@"eeeeeee");
        
        [AppDelegate setGlobal].push=@"YES";
        
       // [[NSNotificationCenter defaultCenter] postNotificationName:@"PushView" object:nil];
        
    }
    else
    {
        [AppDelegate setGlobal].push=@"NO";
    }

    [self.window makeKeyAndVisible];
    return YES;
    
}

//告诉应用程序，能接受push来的通知。
- (void)application:(UIApplication*)application didRegisterForRemoteNotificationsWithDeviceToken:(NSData*)deviceToken
{
    //<f0c2c1ac abbece84 d4b9ded7 ab9d6235 79a1ddf4 6a05575b 35021814 363ccbda>
    //密钥：ios123456
    //NSLog(@"My token is: %@", deviceToken);//获取token
    
    NSString *pushToken = [[[[deviceToken description]
                             stringByReplacingOccurrencesOfString:@"<" withString:@""]
                            stringByReplacingOccurrencesOfString:@">" withString:@""]
                           stringByReplacingOccurrencesOfString:@" " withString:@""];
    //NSLog(@"pushToken::%@",pushToken);
    
    [AppDelegate setGlobal].token=pushToken;

}

//获取收到推送的消息
- (void)application:(UIApplication *)application
didReceiveRemoteNotification:(NSDictionary *)userInfo
{

    //NSLog(@"userInfo::%@",userInfo);
    //[[UIApplication sharedApplication] setApplicationIconBadgeNumber:3];
    
    [AppDelegate setGlobal].push=@"YES";
    AudioServicesPlaySystemSound(1007);
    //AudioServicesPlaySystemSound(1106);
    [[NSNotificationCenter defaultCenter] postNotificationName:@"PushView" object:userInfo];
    
    
}
- (void)application:(UIApplication*)application didFailToRegisterForRemoteNotificationsWithError:(NSError*)error
{
    //NSLog(@"Failed to get token, error: %@", error);
}

- (void)applicationWillResignActive:(UIApplication *)application
{
    // Sent when the application is about to move from active to inactive state. This can occur for certain types of temporary interruptions (such as an incoming phone call or SMS message) or when the user quits the application and it begins the transition to the background state.
     // Use this method to pause ongoing tasks, disable timers, and throttle down OpenGL ES frame rates. Games should use this method to pause the game.
     //[[NSNotificationCenter defaultCenter] postNotificationName:@"refresh" object:nil];
    
}

- (void)applicationDidEnterBackground:(UIApplication *)application
{
    // Use this method to release shared resources, save user data, invalidate timers, and store enough application state information to restore your application to its current state in case it is terminated later. 
    // If your application supports background execution, this method is called instead of applicationWillTerminate: when the user quits.
    
    //点击通知栏目里面通知消失，图标右上角的提示数字消失
    [[UIApplication sharedApplication] setApplicationIconBadgeNumber:0];
    [[UIApplication sharedApplication] cancelAllLocalNotifications];
}


- (void)applicationWillEnterForeground:(UIApplication *)application
{
    // Called as part of the transition from the background to the inactive state; here you can undo many of the changes made on entering the background.
    
    //[[NSNotificationCenter defaultCenter] postNotificationName:@"refresh" object:nil];
    //点击通知栏目里面消失
    [[UIApplication sharedApplication] setApplicationIconBadgeNumber:0];
    [[UIApplication sharedApplication] cancelAllLocalNotifications];
    
    
   
    
    
}

- (void)applicationDidBecomeActive:(UIApplication *)application
{
    // Restart any tasks that were paused (or not yet started) while the application was inactive. If the application was previously in the background, optionally refresh the user interface.
    /*
    application.
    NSLog(@"222222::%d",application.applicationIconBadgeNumber);
    if (application.applicationIconBadgeNumber) {
        
    }
    [AppDelegate setGlobal].push=@"YES";
    AudioServicesPlaySystemSound(1007);
    //AudioServicesPlaySystemSound(1106);
    [[NSNotificationCenter defaultCenter] postNotificationName:@"PushView" object:nil];
   */
    
}

- (void)applicationWillTerminate:(UIApplication *)application
{
    // Called when the application is about to terminate. Save data if appropriate. See also applicationDidEnterBackground:.
}


//全局变量
+(AppDelegate*)setGlobal
{
    return (AppDelegate*)[[UIApplication sharedApplication]delegate];
}



@end
