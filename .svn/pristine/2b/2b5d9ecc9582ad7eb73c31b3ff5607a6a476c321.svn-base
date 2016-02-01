//
//  JsonFactory.h
//  LotteryTicket
//
//  Created by 广喜 晁 on 12-11-15.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>

#import "ASIHTTPRequest.h"//第三方网络请求框架
#import "ASIFormDataRequest.h"
#import "JSONKit.h"//json解析

//协议委托
@protocol responseDelegate <NSObject>

-(void)responseSuccess:(NSDictionary *)dic;//发送成功回调
-(void)responseError:(NSDictionary *)dicErr;//发送失败回调

@end

@interface JsonFactory : NSObject
{
    id<responseDelegate> delegate;
    
    ASIHTTPRequest *dataRequest;
    
}
@property(nonatomic,retain) id<responseDelegate> delegate;

//-(void)getJSONDataByParam:(NSDictionary *)dicparam;
-(void)urlRequest:(NSString *)url;

-(void)commonRequest:(NSString *)classNmae type:(NSString *)type info:(NSString *)info;

@end
