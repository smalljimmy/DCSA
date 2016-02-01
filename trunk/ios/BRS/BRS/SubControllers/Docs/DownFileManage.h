//
//  DownFileManage.h
//  BRS
//
//  Created by cgx on 13-12-11.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "ASIHTTPRequest.h"
#import "ASINetworkQueue.h"

#import "FileModel.h"//文件模型类

//实现代理委托
@protocol DownloadFileDelegate <NSObject>

-(void)startDownload:(ASIHTTPRequest *)request;//开始下载
-(void)updateDownload:(ASIHTTPRequest *)request;//更新下载
-(void)finishedDownload:(ASIHTTPRequest *)request;//完成下载

-(void)allowNextRequest;//处理一个窗口内连续下载多个文件且重复下载的情况


@end


@interface DownFileManage : NSObject<ASIHTTPRequestDelegate,ASIProgressDelegate>
{
    FileModel *fileModel;//文件模型
    
    NSMutableArray *filelist;
    NSMutableArray *finishedlist;//已下载完成的文件列表（文件对象）
    NSMutableArray *downinglist;//正在下载的文件列表(ASIHttpRequest对象)
   
    
    
    id<DownloadFileDelegate> delegate;
}
@property(nonatomic,retain)id<DownloadFileDelegate> delegate;



//将Date格式转换成指定字符串类型
-(NSString *)dateToString:(NSDate*)date;
//初始化数据
- (id)init;
//获取路径
-(NSString *)getPath:(NSString *)path;
//下载文件入口
-(void)downFileUrl:(NSString*)url filename:(NSString*)name path:(NSString *)path;
//暂停下载
//暂停下载
-(void)stopRequest:(ASIHTTPRequest *)request pathLastPart:(NSString *)pathLastPart;

//继续下载
-(void)resumeRequest:(ASIHTTPRequest *)request pathLastPart:(NSString *)pathLastPart fileInfo:(FileModel *)fileInfo;

@end
