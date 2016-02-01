//
//  JsonFactory.m
//  LotteryTicket
//
//  Created by 广喜 晁 on 12-11-15.
//  Copyright (c) 2012年 __MyCompanyName__. All rights reserved.
//

#import "JsonFactory.h"

//http://stdapp.dataforge.ch/bgSplash.jpg
//#define BASE_URL @"http://stdapp.dataforge.ch/"
#define BASE_URL @"http://stdapp.be-appy.ch/"
#define Key @"apitest"

@implementation JsonFactory
@synthesize delegate;

/*
-(void)getJSONDataByParam:(NSDictionary *)dicparam
{    
    //get请求
    NSMutableString *requestString = [[NSMutableString alloc] initWithCapacity:0];
    [requestString appendFormat:@"%@",BASE_URL];
    [requestString appendString:@"?"];
    
    int inputCount = 1;
    NSMutableString *paramString = [NSMutableString stringWithCapacity:0];
	NSArray *arraykeys =[dicparam allKeys];
	for(NSString *key in arraykeys)
    {
        [paramString appendString:key];
        [paramString appendString:@"="];
        [paramString appendFormat:@"%@",(NSString *)[dicparam objectForKey:key]];
        
        if (inputCount <[arraykeys count]) 
        {
            [paramString appendString:@"&"];
            inputCount++;
        }
    }

  // NSLog(@"编码前:%@",paramString);
   NSString *URLStr=[paramString stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding];//utf-8转码。如果有中文,则将中文转码
   //[requestString appendString:[self encodeURL:paramString]];//特殊字符转码
    [requestString appendString:URLStr];
     NSLog(@"编码后:%@",requestString);
    @try 
    {
        if (dataRequest)
        {
            [dataRequest cancel];
            [dataRequest release];
            dataRequest=nil;
        }
        
        dataRequest=[[ASIHTTPRequest alloc] initWithURL:[NSURL URLWithString:requestString]];
        
        dataRequest.delegate=self;
        [dataRequest setRequestMethod:@"GET"];
        
        [dataRequest setTimeOutSeconds:20.0];//设定超时时间
        [dataRequest setPersistentConnectionTimeoutSeconds:20.0];
        
        [dataRequest startAsynchronous];
        
        [requestString release];
        
    }
    @catch (NSException *exception) 
    {
        NSLog(@"exception:->%@",[exception description]);
    }
    @finally 
    {
        
    }
    
}

 */

//特殊字符编码转换
-(NSString *)encodeURL:(NSString *)unescapedString
{
    NSString *escapedUrlString= (NSString *)CFURLCreateStringByAddingPercentEscapes(NULL,(CFStringRef)unescapedString, NULL,(CFStringRef)@"!*'();:@+$,/?%#[]",kCFStringEncodingUTF8);//!*'();:@&=+$,/?%#[]
    
    return [escapedUrlString autorelease];
    
}

//获取信息成功
-(void)requestFinished:(ASIHTTPRequest *)request
{
    NSDictionary *dicData=[[request responseData] objectFromJSONData];//json解析语句
    if ([delegate respondsToSelector:@selector(responseSuccess:)])
    {
        [delegate responseSuccess:dicData];
    }
}

//获取信息失败
-(void)requestFailed:(ASIHTTPRequest *)request
{
    //NSLog(@"requestFailed:%@",request.)
    if ([delegate respondsToSelector:@selector(responseError:)])
    {
        [delegate responseError:[NSDictionary dictionaryWithObject:@"ERROR" forKey:@"error"]];
    }
}


-(void)commonRequest:(NSString *)classNmae type:(NSString *)type info:(NSString *)info
{
    NSMutableString *requestString = [[NSMutableString alloc] initWithCapacity:0];
    /*
    if (type)
    {
         [requestString appendFormat:@"%@%@/",BASE_URL,classNmae];
    }
    else
    {
         [requestString appendFormat:@"%@%@/%@/",BASE_URL,classNmae,Identifier2];
    }
     */
    [requestString appendFormat:@"%@%@/%@/",BASE_URL,classNmae,Identifier2];
   
   
    if (type==nil)
    {
        ;
    }
    else
    {
        [requestString appendFormat:@"%@/",type];
    }
    if (info==nil)
    {
        ;
    }
    else
    {
        [requestString appendFormat:@"%@/",info];
    }
    
    //NSLog(@"requestString:%@",requestString);
    @try
    {
        if (dataRequest)
        {
            [dataRequest cancel];
            [dataRequest release];
            dataRequest=nil;
        }
        
        dataRequest=[[ASIHTTPRequest alloc] initWithURL:[NSURL URLWithString:requestString]];
        
        dataRequest.delegate=self;
        [dataRequest setRequestMethod:@"GET"];
        
        [dataRequest setTimeOutSeconds:10.0];//设定超时时间
        [dataRequest setPersistentConnectionTimeoutSeconds:10.0];
        
        [dataRequest startAsynchronous];
        
        [requestString release];
        
    }
    @catch (NSException *exception)
    {
       // NSLog(@"exception:->%@",[exception description]);
    }
    @finally
    {
        
    }
}

//直接使用URL请求
-(void)urlRequest:(NSString *)url
{
    @try
    {
        if (dataRequest)
        {
            [dataRequest cancel];
            [dataRequest release];
            dataRequest=nil;
        }
        
        dataRequest=[[ASIHTTPRequest alloc] initWithURL:[NSURL URLWithString:url]];
        
        dataRequest.delegate=self;
        [dataRequest setRequestMethod:@"GET"];
        
        [dataRequest setTimeOutSeconds:20.0];//设定超时时间
        [dataRequest setPersistentConnectionTimeoutSeconds:20.0];
        
        [dataRequest startAsynchronous];
        
    }
    @catch (NSException *exception)
    {
        NSLog(@"exception:->%@",[exception description]);
    }
    @finally
    {
        
    }

}



@end
