//
//  DownFileManage.m
//  BRS
//
//  Created by cgx on 13-12-11.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import "DownFileManage.h"


#define DownFinishPath @"downFinish/"
#define DownTempPath @"downtemp/"

@implementation DownFileManage
@synthesize delegate;


//初始化数据
- (id)init
{
	self = [super init];
	if (self != nil)
    {
        
        filelist = [[NSMutableArray alloc]init];
        downinglist=[[NSMutableArray alloc] init];
        finishedlist = [[NSMutableArray alloc] init];
        
    }
	return self;
}

//将Date格式转换成指定字符串类型
-(NSString *)dateToString:(NSDate*)date
{
    NSDateFormatter *df=[[NSDateFormatter alloc] init];
    [df setDateFormat:@"MM-dd HH:mm:ss"];//[df setDateFormat:@"yyyy-MM-dd HH:mm:ss"];
    NSString *datestr = [df stringFromDate:date];
    [df release];
    
    return datestr;
}

//获取路径
-(NSString *)getPath:(NSString *)path
{
    NSString *pathstr =[NSHomeDirectory() stringByAppendingPathComponent:@"Documents"];
    pathstr = [pathstr stringByAppendingPathComponent:path];
    
    return pathstr;
}

//创建路径
-(BOOL)createPath:(NSString *)path
{
    NSFileManager *fileManager=[NSFileManager defaultManager];
    NSError *error;
    
    if(![fileManager fileExistsAtPath:path])//如果路径不存在，则创建路径
    {
        [fileManager createDirectoryAtPath:path withIntermediateDirectories:YES attributes:nil error:&error];
        if(!error)
        {
           // NSLog(@"11111%@",[error description]);
            return NO;
        }
        else
        {
           // NSLog(@"tttttsssssss");
            return YES;
        }
    }
    return YES;

}




//下载文件入口
-(void)downFileUrl:(NSString*)url filename:(NSString *)name path:(NSString *)path
{
    
    if (fileModel)
    {
        [fileModel release];
        fileModel = nil;
    }
    fileModel = [[FileModel alloc]init];//文件模型初始化
    
    fileModel.fileName = name;//名称
    fileModel.fileURL = url;//URL

    NSDate *myDate = [NSDate date];
    fileModel.time = [self dateToString:myDate];//将当前时间的格式转化为=>MM-dd HH:mm:ss此格式
    
    fileModel.fileType=[name pathExtension];
    
    fileModel.targetPath = [self getPath:[NSString stringWithFormat:@"%@%@",DownFinishPath,name]];//下载完成路径
    //NSLog(@"targetPath::%@",fileModel.targetPath);
    
    fileModel.tempPath = [self getPath:[NSString stringWithFormat:@"%@%@",DownTempPath,name]];//临时路径
    //NSLog(@"tempPath::%@",fileModel.tempPath);
    
    
    if([[NSFileManager defaultManager] fileExistsAtPath:fileModel.targetPath])//已经存在下载文件路径
    {
        /*
        UIAlertView *alert=[[UIAlertView alloc] initWithTitle:@"温馨提示" message:@"该文件已下载，是否重新下载？" delegate:self cancelButtonTitle:@"取消" otherButtonTitles:@"确定", nil];
        [alert show];
        [alert release];
         */
        
        
        return;
    }
    
    
    if([[NSFileManager defaultManager] fileExistsAtPath: fileModel.tempPath])
    {
        /*
        UIAlertView *alert=[[UIAlertView alloc] initWithTitle:@"温馨提示" message:@"该文件已经在下载列表中了，是否重新下载？" delegate:self cancelButtonTitle:@"取消" otherButtonTitles:@"确定", nil];
        [alert show];
        [alert release];
         */
        
        return;
    }

    
    
    
    fileModel.isDownloading=YES;
    fileModel.willDownloading = YES;
    fileModel.error = NO;
    fileModel.isFirstReceived = YES;
    
   
    
    //若不存在文件和临时文件，则是新的下载
    [filelist addObject:fileModel];
    
    [self startLoad];//开始下载

}


-(void)startLoad
{
    NSInteger num = 0;
    NSInteger max = 3;
    for (FileModel *file in filelist)
    {
        if (!file.error)
        {
            if (file.isDownloading==YES)
            {
                file.willDownloading = NO;
                
                if (num>max)
                {
                    file.isDownloading = NO;
                    file.willDownloading = YES;
                }
                else
                {
                    num++;
                }
            }
        }
    }
    if (num<max)
    {
        for (FileModel *file in filelist)
        {
            if (!file.error)
            {
                if (!file.isDownloading && file.willDownloading)
                {
                    num++;
                    if (num>max)
                    {
                        break;
                    }
                    file.isDownloading = YES;
                    file.willDownloading = NO;
                }
            }
        }
        
    }
    for (FileModel *file in filelist)
    {
        if (!file.error)
        {
            if (file.isDownloading==YES)
            {
                [self beginRequest:file isBeginDown:YES];//开始请求下载
            }
            else
            {
                [self beginRequest:file isBeginDown:NO];
            }
        }
    }
    
    
    //self.count = [_filelist count];
    
}


-(void)saveDownloadFile:(FileModel*)fileinfo
{
    NSDictionary *filedic = [NSDictionary dictionaryWithObjectsAndKeys:fileinfo.fileName,@"filename",fileinfo.fileURL,@"fileurl",fileinfo.time,@"time",fileinfo.tempPath,@"tempPath",fileinfo.targetPath,@"targetPath" ,fileinfo.fileSize,@"filesize",fileinfo.fileReceivedSize,@"filerecievesize",nil];
    
   // NSLog(@"112233::%@",[[fileinfo.fileName componentsSeparatedByString:@"."] objectAtIndex:0]) ;;

    if([self createPath:[self getPath:DownTempPath]] && [self createPath:[self getPath:DownFinishPath]])//创建文件夹
    {
        if (![filedic writeToFile:[self getPath:[NSString stringWithFormat:@"%@%@.plist",DownTempPath,[[fileinfo.fileName componentsSeparatedByString:@"."] objectAtIndex:0]]]atomically:YES])
        {
            //NSLog(@"写入临时文件失败");
        }
        else
        {
           // NSLog(@"写入临时文件成功");
        }

    }

    
    
}




-(void)beginRequest:(FileModel *)fileInfo isBeginDown:(BOOL)isBeginDown
{
    for(ASIHTTPRequest *tempRequest in downinglist)//过滤
    {
      //  NSLog(@"urlllll:%@",[tempRequest.url absoluteString]);
        
        if([[[tempRequest.url absoluteString]lastPathComponent] isEqualToString:[fileInfo.fileURL lastPathComponent]])
        {
            if ([tempRequest isExecuting] && isBeginDown)
            {
                return;
            }
            else if ([tempRequest isExecuting] && !isBeginDown)
            {
                [tempRequest setUserInfo:[NSDictionary dictionaryWithObject:fileInfo forKey:@"File"]];
                [tempRequest cancel];
                
               // [self.downloadDelegate updateCellProgress:tempRequest];
                
                return;
            }
        }
    }
    
    [self saveDownloadFile:fileInfo];//保存下载文件

    //按照获取的文件名获取临时文件的大小，即已下载的大小
    fileInfo.isFirstReceived=YES;
    NSFileManager *fileManager=[NSFileManager defaultManager];
    NSData *fileData=[fileManager contentsAtPath:fileInfo.tempPath];
    NSInteger receivedDataLength=[fileData length];
    fileInfo.fileReceivedSize=[NSString stringWithFormat:@"%d",receivedDataLength];
    
    //NSLog(@"start down::已经下载：%@",fileInfo.fileReceivedSize);
   
    ASIHTTPRequest *request=[[ASIHTTPRequest alloc] initWithURL:[NSURL URLWithString:fileInfo.fileURL]];
    request.delegate=self;
    [request setDownloadDestinationPath:[fileInfo targetPath]];
    [request setTemporaryFileDownloadPath:fileInfo.tempPath];
    [request setDownloadProgressDelegate:self];
    [request setNumberOfTimesToRetryOnTimeout:2];
    //[request setShouldContinueWhenAppEntersBackground:YES];
    //[request setDownloadProgressDelegate:downCell.progress];//设置进度条的代理,这里由于下载是在AppDelegate里进行的全局下载，所以没有使用自带的进度条委托，这里自己设置了一个委托，用于更新UI
    [request setAllowResumeForFileDownloads:YES];//支持断点续传
    
    
    [request setUserInfo:[NSDictionary dictionaryWithObject:fileInfo forKey:@"File"]];//设置上下文的文件基本信息
    [request setTimeOutSeconds:30.0f];
    if (isBeginDown)
    {
        [request startAsynchronous];
    }
    
    //如果文件重复下载或暂停、继续，则把队列中的请求删除，重新添加
    BOOL exit = NO;
    for(ASIHTTPRequest *tempRequest in downinglist)
    {
        //  NSLog(@"!!!!---::%@",[tempRequest.url absoluteString]);
        if([[[tempRequest.url absoluteString]lastPathComponent] isEqualToString:[fileInfo.fileURL lastPathComponent] ])
        {
            [downinglist replaceObjectAtIndex:[downinglist indexOfObject:tempRequest] withObject:request];
            
            exit = YES;
            break;
        }
    }
    
    if (!exit)
    {
        [downinglist addObject:request];
       // NSLog(@"EXIT!!!!---::%@",[request.url absoluteString]);
    }
    [delegate updateDownload:request];
    [request release];
    
}


#pragma mark -- ASIHttpRequest回调委托 --

//出错了，如果是等待超时，则继续下载
-(void)requestFailed:(ASIHTTPRequest *)request
{
    NSError *error=[request error];
    //NSLog(@"ASIHttpRequest出错了!%@",error);
    if (error.code==4)
    {
        return;
    }
    if ([request isExecuting])
    {
        [request cancel];
    }
    FileModel *fileInfo =  [request.userInfo objectForKey:@"File"];
    fileInfo.isDownloading = NO;
    fileInfo.willDownloading = NO;
    fileInfo.error = YES;
    for (FileModel *file in filelist)
    {
        if ([file.fileName isEqualToString:fileInfo.fileName])
        {
            file.isDownloading = NO;
            file.willDownloading = NO;
            file.error = YES;
        }
    }
    
    [delegate updateDownload:request];
}

-(void)requestStarted:(ASIHTTPRequest *)request
{
   // NSLog(@"开始了!");
}

-(void)request:(ASIHTTPRequest *)request didReceiveResponseHeaders:(NSDictionary *)responseHeaders
{
   // NSLog(@"收到回复了！");
    
    FileModel *fileInfo=[request.userInfo objectForKey:@"File"];
    NSString *len = [responseHeaders objectForKey:@"Content-Length"];//
    // NSLog(@"%@,%@,%@",fileInfo.fileSize,fileInfo.fileReceivedSize,len);
    //这个信息头，首次收到的为总大小，那么后来续传时收到的大小为肯定小于或等于首次的值，则忽略
    if ([fileInfo.fileSize longLongValue]> [len longLongValue])
    {
        return;
    }
    
    fileInfo.fileSize = [NSString stringWithFormat:@"%lld",  [len longLongValue]];
    [self saveDownloadFile:fileInfo];//更新保存的临时文件
    
}


-(void)request:(ASIHTTPRequest *)request didReceiveBytes:(long long)bytes
{
    FileModel *fileInfo=[request.userInfo objectForKey:@"File"];
   // NSLog(@"%@,%lld",fileInfo.fileReceivedSize,bytes);
    if (fileInfo.isFirstReceived)
    {
        fileInfo.isFirstReceived=NO;
        fileInfo.fileReceivedSize =[NSString stringWithFormat:@"%lld",bytes];
    }
    else if(!fileInfo.isFirstReceived)
    {
        fileInfo.fileReceivedSize=[NSString stringWithFormat:@"%lld",[fileInfo.fileReceivedSize longLongValue]+bytes];
    }
    
    [self saveDownloadFile:fileInfo];
    
    if([delegate respondsToSelector:@selector(updateDownload:)])
    {
        [delegate updateDownload:request];
    }
    
}

//将正在下载的文件请求ASIHttpRequest从队列里移除，并将其配置文件删除掉,然后向已下载列表里添加该文件对象
-(void)requestFinished:(ASIHTTPRequest *)request
{

    FileModel *fileInfo=(FileModel *)[request.userInfo objectForKey:@"File"];
    [finishedlist addObject:fileInfo];
    
   // NSString *configPath=fileInfo.tempPath;
    NSFileManager *fileManager=[NSFileManager defaultManager];
    NSError *error;
    
    NSString *configPath=[self getPath:[NSString stringWithFormat:@"%@%@.plist",DownTempPath,[[fileInfo.fileName componentsSeparatedByString:@"."] objectAtIndex:0]]];
    if([fileManager fileExistsAtPath:configPath])//如果存在临时文件的配置文件
    {
        [fileManager removeItemAtPath:configPath error:&error];
        if(!error)
        {
            //NSLog(@"%@",[error description]);
        }
    }
    
    [filelist removeObject:fileInfo];
    [downinglist removeObject:request];
    
    [self saveFinishedFile];
    [self startLoad];
    
    if([delegate respondsToSelector:@selector(finishedDownload:)])
    {
        [delegate finishedDownload:request];
    }
}

//保存下载完成文件
-(void)saveFinishedFile
{
    if (finishedlist==nil)
    {
        return;
    }
    
    NSMutableArray *finishedinfo = [[NSMutableArray alloc]init];
    for (FileModel *fileinfo in finishedlist)
    {
        NSDictionary *filedic = [NSDictionary dictionaryWithObjectsAndKeys:fileinfo.fileName,@"filename",fileinfo.time,@"time",fileinfo.fileSize,@"filesize",fileinfo.targetPath,@"filepath",nil];
        
        
        [finishedinfo addObject:filedic];
    }
    
    
    if([self createPath:[self getPath:DownFinishPath]])//创建临时文件夹
    {
        if (![finishedinfo writeToFile:[self getPath:[NSString stringWithFormat:@"%@/finishPlist.plist",DownFinishPath] ]atomically:YES])
        {
            //NSLog(@"写入完成失败");
        }
        else
        {
            //NSLog(@"写入完成文件成功");
        }
        
    }
    
    [finishedinfo release];
}
    

//暂停下载
-(void)stopRequest:(ASIHTTPRequest *)request pathLastPart:(NSString *)pathLastPart
{
    NSInteger max = 3;
    
    //FileModel *fileInfo = [request.userInfo objectForKey:@"File"];
    for (FileModel *file in filelist)
    {
        if ([file.fileName isEqualToString:pathLastPart])
        {
            if([request isExecuting])
            {
                [request cancel];
            }
            
            file.isDownloading = NO;
            file.willDownloading = NO;
            break;
        }
    }
    NSInteger downingcount =0;
    
    for (FileModel *file in filelist)
    {
        if (file.isDownloading) {
            downingcount++;
        }
    }
    if (downingcount<max)
    {
        for (FileModel *file in filelist)
        {
            if (!file.isDownloading&&file.willDownloading){
                file.isDownloading = YES;
                file.willDownloading = NO;
                break;
            }
        }
    }
    
    [self startLoad];
    
}

//继续下载
-(void)resumeRequest:(ASIHTTPRequest *)request pathLastPart:(NSString *)pathLastPart fileInfo:(FileModel *)fileInfo
{
   // NSLog(@"jixu");
    
    if ([filelist count]==0)
    {
        [filelist addObject:fileInfo];
    }
    
    NSInteger max = 3;
   // FileModel *fileInfo =  [request.userInfo objectForKey:@"File"];
    NSInteger downingcount =0;
    NSInteger indexmax =-1;
    for (FileModel *file in filelist)
    {
        if (file.isDownloading)
        {
            downingcount++;
            if (downingcount==max)
            {
                indexmax = [filelist indexOfObject:file];
            }
        }
    }//此时下载中数目是否是最大，并获得最大时的位置Index
    if (downingcount==max) {
        FileModel *file  = [filelist objectAtIndex:indexmax];
        if (file.isDownloading)
        {
            file.isDownloading = NO;
            file.willDownloading = YES;
        }
    }//中止一个进程使其进入等待
    
    //NSLog(@"file::%@",filelist);
    for (FileModel *file in filelist)
    {
        if ([file.fileName isEqualToString:pathLastPart])
        {
            //NSLog(@"2222222");
            NSString *pdfUrl=[NSString stringWithFormat:@"%@%@",[AppDelegate setGlobal].baseUrl,pathLastPart];
            file.fileURL=pdfUrl;
            file.isDownloading = YES;
            file.willDownloading = NO;
            file.error = NO;
        }
    }
    
    //重新开始此下载
    [self startLoad];
}






@end
