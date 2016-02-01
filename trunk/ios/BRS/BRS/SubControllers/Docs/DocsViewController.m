//
//  DocsViewController.m
//  BRS
//
//  Created by cgx on 13-10-28.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import "DocsViewController.h"


#define DownFinishPath @"downFinish/"
#define DownTempPath @"downtemp/"

#define DEMO_VIEW_CONTROLLER_PUSH FALSE

@interface DocsViewController ()

@end

@implementation DocsViewController
@synthesize subtype;
@synthesize urlLinking;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.

    [defaultView removeFromSuperview];
    [WebdefaultView removeFromSuperview];
    

    if (subtype==0)
    {
        if ([urlLinking hasPrefix:@"<"])
        {
            [self defaultView];
        }
        else
        {
            [self defaultText:urlLinking];
        }
        
    }
    else if(subtype==2)
    {
        [self WebdefaultView:urlLinking];
    }
    else
    {
        downManage=[[DownFileManage alloc]init];//初始化下载管理
        downManage.delegate=self;
        
        docsTableView=[[UITableView alloc]initWithFrame:CGRectMake(0,0, WIDTH, 416+(iPhone5?88:0))];
        docsTableView.separatorStyle=UITableViewCellSeparatorStyleNone;
        docsTableView.backgroundView=nil;
        docsTableView.backgroundColor=[UIColor clearColor];
        docsTableView.delegate=self;
        docsTableView.dataSource=self;
        [self.view addSubview:docsTableView];
        [docsTableView release];
        
        flag=0;
        
        // 下拉刷新
        _header = [[MJRefreshHeaderView alloc] init];
        _header.scrollView =docsTableView;
        _header.delegate = self;
        

    }
    
    //NSLog(@"111111");
}



//上拉更新加载更多数据
#pragma mark - 刷新的代理方法---进入下拉刷新\上拉加载更多都有可能调用这个方法
- (void)refreshViewBeginRefreshing:(MJRefreshBaseView *)refreshView
{
    if(refreshView==_header)//刷新首页
    {
        [[self requestFactory] commonRequest:Resource type:@"1" info:nil];
        
    }
}



-(void)viewDidAppear:(BOOL)animated
{
    if (subtype==1)
    {
        if (flag==0)
        {
            //接口请求
            [ToolLen ShowWaitingView:YES];
            
            [[self requestFactory] commonRequest:Resource type:@"1" info:nil];
            flag++;
        }

    }
    
}

-(void)responseSuccess:(NSDictionary *)dic
{
    [ToolLen ShowWaitingView:NO];
    //NSLog(@"dic::%@",dic);
    
    
    docsArray=[[NSArray alloc] initWithArray:(NSArray *)dic];
    
    [docsTableView reloadData];
    
    // 结束刷新状态
    [_header endRefreshing];
    
}

-(void)responseError:(NSDictionary *)dicErr
{
    [ToolLen ShowWaitingView:NO];
}


-(NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return 1;
}

-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return [docsArray count];
}

-(float)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
    return 70.0;
}
-(UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *cellIndefiner=@"cellIndefiner";
    DocsCell *cell=(DocsCell *)[tableView dequeueReusableCellWithIdentifier:cellIndefiner];
    if (cell==nil)
    {
        NSArray *xib=[[NSBundle mainBundle]loadNibNamed:@"DocsCell" owner:self options:nil];
        cell=[xib objectAtIndex:0];
        [cell setSelectionStyle:UITableViewCellSelectionStyleNone];
    }
/*
    //pdf的url路径
    NSString *pdfUrl=[NSString stringWithFormat:@"%@%@",[AppDelegate setGlobal].baseUrl,[[docsArray objectAtIndex:indexPath.row] objectForKey:@"path"]];
    
    FileModel *fileInfo=[req.userInfo objectForKey:@"File"];
*/
    
    //下载到本地
    if ([[NSFileManager defaultManager] fileExistsAtPath:[downManage getPath:[NSString stringWithFormat:@"%@%@",DownFinishPath,[[docsArray objectAtIndex:indexPath.row] objectForKey:@"path"]]]])
    {
        cell.titleLabel.text=[[docsArray objectAtIndex:indexPath.row] objectForKey:@"title"];
        cell.messageLabel.text=[[docsArray objectAtIndex:indexPath.row] objectForKey:@"content"];
        cell.progressLabel.text=@"100%";
        cell.desImageView.hidden=YES;
        cell.desLabel.hidden=NO;
        cell.desLabel.text=@"öffnen";
        cell.downLoadButton.tag=indexPath.row;
        [cell.downLoadButton addTarget:self action:@selector(read:) forControlEvents:UIControlEventTouchUpInside];
    }
    else if([[NSFileManager defaultManager] fileExistsAtPath:[downManage getPath:[NSString stringWithFormat:@"%@%@",DownTempPath,[[docsArray objectAtIndex:indexPath.row] objectForKey:@"path"]]]])//说明当前的cell为下载内容
    {
        
        NSDictionary *dic=[NSDictionary dictionaryWithContentsOfFile:[downManage getPath:[NSString stringWithFormat:@"%@%@.plist",DownTempPath,[[[[docsArray objectAtIndex:indexPath.row] objectForKey:@"path"] componentsSeparatedByString:@"."] objectAtIndex:0]]]];
        
        //NSLog(@"dic::%@",dic);
        
        cell.titleLabel.text=[[docsArray objectAtIndex:indexPath.row] objectForKey:@"title"];
        cell.messageLabel.text=[[docsArray objectAtIndex:indexPath.row] objectForKey:@"content"];
        cell.progressLabel.text =[NSString stringWithFormat:@"%.0f%@",100*([[dic objectForKey:@"filerecievesize"] floatValue]/[[dic objectForKey:@"filesize"] floatValue]),@"%"];//百分比
        cell.desImageView.hidden=YES;
        cell.desLabel.hidden=NO;
            
        cell.downLoadButton.tag=indexPath.row;
        
       // cell.desLabel.text=@"continue";
        [cell.downLoadButton addTarget:self action:@selector(goCon:) forControlEvents:UIControlEventTouchUpInside];
        
        
        
         /*
        if(fileInfo.isDownloading)//文件正在下载
        {
            cell.desLabel.text=@"暂停";
            [cell.downLoadButton addTarget:self action:@selector(pause:) forControlEvents:UIControlEventTouchUpInside];
        }
        else if(!fileInfo.isDownloading && !fileInfo.willDownloading&&!fileInfo.error)
        {
          
                
        }
        else if(!fileInfo.isDownloading && fileInfo.willDownloading&&!fileInfo.error)
        {
                
        }
        else if (fileInfo.error)
        {
                
        }
          */
        
    }
    
    else //未点击下载内容
    {
        cell.titleLabel.text=[[docsArray objectAtIndex:indexPath.row] objectForKey:@"title"];
        cell.messageLabel.text=[[docsArray objectAtIndex:indexPath.row] objectForKey:@"content"];
        //cell.progressLabel.text=@"down";
        cell.desImageView.hidden=NO;
        cell.desLabel.hidden=YES;
        cell.downLoadButton.tag=indexPath.row;
        [cell.downLoadButton addTarget:self action:@selector(downLoading:) forControlEvents:UIControlEventTouchUpInside];
        
    }

    
    
    
    return cell;
    
}

//点击下载
-(void)downLoading:(id)sender
{
    int tag=[sender tag];
    
    NSString *pdfUrl=[NSString stringWithFormat:@"%@%@",[AppDelegate setGlobal].baseUrl,[[docsArray objectAtIndex:tag] objectForKey:@"path"]];
    
    //NSLog(@"pdf::%@",pdfUrl);
    
    [downManage downFileUrl:pdfUrl filename:[[docsArray objectAtIndex:tag] objectForKey:@"path"] path:[[docsArray objectAtIndex:tag] objectForKey:@"path"]];
    
    
    [docsTableView reloadData];//刷新列表
}

-(void)read:(id)sender
{
    //点击阅读
    
    NSString *phrase = nil; // Document password (for unlocking most encrypted PDF files)
    
	//NSArray *pdfs = [[NSBundle mainBundle] pathsForResourcesOfType:@"pdf" inDirectory:nil];
    
	NSString *filePath = [downManage getPath:[NSString stringWithFormat:@"%@%@",DownFinishPath,[[docsArray objectAtIndex:[sender tag]] objectForKey:@"path"]]];//[pdfs lastObject];
    
    assert(filePath != nil); // Path to last PDF file
    //NSLog(@"filePath::%@",filePath);
    
	ReaderDocument *document = [ReaderDocument withDocumentFilePath:filePath password:phrase];
    
	if (document != nil) // Must have a valid ReaderDocument object in order to proceed with things
	{
		ReaderViewController *readerViewController = [[ReaderViewController alloc] initWithReaderDocument:document];
        
		readerViewController.delegate = self; // Set the ReaderViewController delegate to self
        
#if (DEMO_VIEW_CONTROLLER_PUSH == TRUE)
        
		[self.navigationController pushViewController:readerViewController animated:YES];
        
#else // present in a modal view controller
        
		readerViewController.modalTransitionStyle = UIModalTransitionStyleCrossDissolve;
		readerViewController.modalPresentationStyle = UIModalPresentationFullScreen;
        
		[self presentModalViewController:readerViewController animated:YES];
        
#endif // DEMO_VIEW_CONTROLLER_PUSH
        
		[readerViewController release]; // Release the ReaderViewController
	}

    
}


- (void)dismissReaderViewController:(ReaderViewController *)viewController
{
    
#if (DEMO_VIEW_CONTROLLER_PUSH == TRUE)
    
	[self.navigationController popViewControllerAnimated:YES];
    
#else // dismiss the modal view controller
    
	[self dismissModalViewControllerAnimated:YES];
    
#endif // DEMO_VIEW_CONTROLLER_PUSH
}



-(void)updateCellOnMainThread:(FileModel *)fileInfo
{
  
    for (int i=0; i<[docsArray count]; i++)
    {
        NSString *pdfUrl=[NSString stringWithFormat:@"%@%@",[AppDelegate setGlobal].baseUrl,[[docsArray objectAtIndex:i] objectForKey:@"path"]];
        
        NSIndexPath *ip = [NSIndexPath indexPathForRow:i inSection:0];
        DocsCell *cell=(DocsCell *)[docsTableView cellForRowAtIndexPath:ip];
        
        if ([fileInfo.fileURL isEqualToString:pdfUrl])
        {
            cell.progressLabel.text =[NSString stringWithFormat:@"%.0f%@",100*([fileInfo.fileReceivedSize floatValue]/[fileInfo.fileSize floatValue]),@"%"];//百分比
            
            if(fileInfo.isDownloading)//文件正在下载
            {
                cell.desImageView.hidden=YES;
                cell.desLabel.hidden=NO;
                cell.desLabel.text=@"pause";
                cell.downLoadButton.tag=i;
                [cell.downLoadButton addTarget:self action:@selector(pause:) forControlEvents:UIControlEventTouchUpInside];
                
            }
            
        }
    }
    
}



#pragma mark --- updateUI delegate ---
-(void)startDownload:(ASIHTTPRequest *)request//开始下载
{
    
}
-(void)updateDownload:(ASIHTTPRequest *)request//更新下载
{
    //NSLog(@"111111111");
    FileModel *fileInfo=[request.userInfo objectForKey:@"File"];
    
    [self performSelectorOnMainThread:@selector(updateCellOnMainThread:) withObject:fileInfo waitUntilDone:YES];
}
-(void)finishedDownload:(ASIHTTPRequest *)request//完成下载
{
    //NSLog(@"");
    
    [docsTableView reloadData];//刷新列表
}


- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

//暂停
-(void)pause:(id)sender
{
   // NSLog(@"pause::::");
    
    
     ASIHTTPRequest * obj = nil;
     [downManage stopRequest:obj pathLastPart:[[docsArray objectAtIndex:[sender tag]] objectForKey:@"path"]];
    
    //[docsTableView reloadData];
}

//继续
-(void)goCon:(id)sender
{
    //NSLog(@"goon.....");
    
    
    NSDictionary *dic=[NSDictionary dictionaryWithContentsOfFile:[downManage getPath:[NSString stringWithFormat:@"%@%@.plist",DownTempPath,[[[[docsArray objectAtIndex:[sender tag]] objectForKey:@"path"] componentsSeparatedByString:@"."] objectAtIndex:0]]]];
    
   // NSLog(@"dic::%@",dic);
    FileModel *fileModel = [[FileModel alloc]init];//文件模型初始化
    
    fileModel.fileName = [dic objectForKey:@"filename"];//名称
    fileModel.fileURL = [dic objectForKey:@"fileurl"];//URL
    
    NSDate *myDate = [NSDate date];
    fileModel.time = [downManage dateToString:myDate];//将当前时间的格式转化为=>MM-dd HH:mm:ss此格式
    
    fileModel.fileType=[[dic objectForKey:@"filename"] pathExtension];
    fileModel.fileReceivedSize=[dic objectForKey:@"filerecievesize"];
    fileModel.fileSize=[dic objectForKey:@"filesize"];
    fileModel.targetPath = [downManage getPath:[NSString stringWithFormat:@"%@%@",DownFinishPath,fileModel.fileName]];//下载完成路径
   // NSLog(@"targetPath::%@",fileModel.targetPath);
    
    fileModel.tempPath = [downManage getPath:[NSString stringWithFormat:@"%@%@",DownTempPath,fileModel.fileName]];//临时路径
   // NSLog(@"tempPath::%@",fileModel.tempPath);


    ASIHTTPRequest * obj = nil;
    [downManage resumeRequest:obj pathLastPart:[[docsArray objectAtIndex:[sender tag]] objectForKey:@"path"] fileInfo:fileModel];
    

}

@end
