//
//  ToolLen.m
//  SuiXingPay
//
//  Created by wei peng on 12-9-13.
//
//

#import "ToolLen.h"
#import "LeoLoadingView.h"


@implementation ToolLen

static UIView * aview;
static LeoLoadingView *loadingView;

+(void)ShowWaitingView:(BOOL)isShow
{
    if (isShow)
    {
        aview=[[UIView alloc] initWithFrame:CGRectMake(0, 0, 320, 480+(iPhone5?88:0))];
        aview.backgroundColor=[UIColor colorWithRed:0.0 green:0.0 blue:0.0 alpha:0.8];
        
        loadingView=[[LeoLoadingView alloc]initWithFrame:CGRectMake(130, (460+(iPhone5?88:0))/2-30, 60, 60)];
        [aview addSubview:loadingView];
        [loadingView showView:YES];
        
        [[UIApplication sharedApplication].keyWindow addSubview:aview];
    }
    else
    {
        if (aview)
        {
            [aview removeFromSuperview];
            [aview setHidden:YES];
            [loadingView showView:NO];
            [loadingView removeFromSuperview];
            
        }
    }
}

//必须加入一个frameworks:systemconfiguration.framework,和头文件:#import <SystemConfiguration/SCNetworkReachability.h> ,还有自定义类:.h和.m文件。
//判断是那一种网络

+(BOOL)adujestNetwork
{
    Reachability *Network = [Reachability reachabilityWithHostName:@"www.apple.com"];
    switch ([Network currentReachabilityStatus]) 
    {
        case NotReachable:
        {
            //没有网络连接
            return NO;
            break;
        }
        case ReachableViaWWAN:
        {
            //使用3G网络
            return YES;
            break;
        }
        case ReachableViaWiFi:
        {
            //使用WiFi网络
            return YES;
            break;
        }
    }
    return NO;
}


@end
