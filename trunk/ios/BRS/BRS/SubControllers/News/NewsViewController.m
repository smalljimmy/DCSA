//
//  NewsViewController.m
//  BRS
//
//  Created by cgx on 13-10-28.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import "NewsViewController.h"

@interface NewsViewController ()

@end

@implementation NewsViewController
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
    

    if (subtype==0)//news默认显示iss文本
    {
        //NSLog(@"iss");
      // [self defaultView];
        
        newsTableView=[[UITableView alloc]initWithFrame:CGRectMake(0,0, WIDTH, 416+(iPhone5?88:0))];
        newsTableView.separatorStyle=UITableViewCellSeparatorStyleNone;
        newsTableView.backgroundView=nil;
        newsTableView.backgroundColor=[UIColor clearColor];
        newsTableView.delegate=self;
        newsTableView.dataSource=self;
        [self.view addSubview:newsTableView];
        [newsTableView release];
        
        // 下拉刷新
        _header = [[MJRefreshHeaderView alloc] init];
        _header.scrollView =newsTableView;
        _header.delegate = self;
        
    }
    else if(subtype==2)//news为2时显示网页内容
    {
        [self WebdefaultView:urlLinking];
    }
    else
    {
        newsTableView=[[UITableView alloc]initWithFrame:CGRectMake(0,0, WIDTH, 416+(iPhone5?88:0))];
        newsTableView.separatorStyle=UITableViewCellSeparatorStyleNone;
        newsTableView.backgroundView=nil;
        newsTableView.backgroundColor=[UIColor clearColor];
        newsTableView.delegate=self;
        newsTableView.dataSource=self;
        [self.view addSubview:newsTableView];
        [newsTableView release];
        
        // 下拉刷新
        _header = [[MJRefreshHeaderView alloc] init];
        _header.scrollView =newsTableView;
        _header.delegate = self;
        
        
        newsInfo=[[NewsInfoView alloc]initWithFrame:CGRectMake(0, 460+(iPhone5?88:0),WIDTH, 460+(iPhone5?88:0))  type:@"news" content:@""];
        
        newsInfo.delegate=self;
        
        [self.view addSubview:newsInfo];
    }
}

-(void)viewDidAppear:(BOOL)animated
{
    if (subtype==0)
    {
       // [ToolLen ShowWaitingView:YES];
        itemArray=nil;
        titleArray=nil;
        descriptionArray=nil;
        pubDateArray=nil;
        linkArray=nil;
        
        NSXMLParser* parser = [[NSXMLParser alloc] initWithContentsOfURL:[NSURL URLWithString:urlLinking]];
        
        parser.delegate = self;
        
        [ToolLen ShowWaitingView:YES];
        [parser parse];
        
    }
   else
   {
       if (subtype==1)
       {
           //接口请求
           [ToolLen ShowWaitingView:YES];
           [[self requestFactory] commonRequest:Message type:@"6" info:nil];
       }
   }
}


-(void)stopRefresh
{
    // 结束刷新状态
    [_header endRefreshing];
}
//上拉更新加载更多数据
#pragma mark - 刷新的代理方法---进入下拉刷新\上拉加载更多都有可能调用这个方法
- (void)refreshViewBeginRefreshing:(MJRefreshBaseView *)refreshView
{
    if(refreshView==_header)//刷新首页
    {
        if (subtype==0)
        {
            
            
            [self performSelector:@selector(stopRefresh) withObject:nil afterDelay:2.0];
            /*
            itemArray=nil;
            titleArray=nil;
            descriptionArray=nil;
            pubDateArray=nil;
            linkArray=nil;
            
            [ToolLen ShowWaitingView:YES];
            
            NSXMLParser *parser = [[NSXMLParser alloc] initWithContentsOfURL:[NSURL URLWithString:urlLinking]];
            parser.delegate = self;
            [parser parse];
             */
            
        }
        else
        {
             [[self requestFactory] commonRequest:Message type:@"6" info:nil];
        }
    }
}



-(void)responseSuccess:(NSDictionary *)dic
{
    [ToolLen ShowWaitingView:NO];
    //NSLog(@"dic::%@",dic);
    if ([dic count]>0)
    {
        newsArray=[[NSMutableArray alloc]initWithArray:(NSArray *)dic];
        
        [newsTableView reloadData];
        // 结束刷新状态
        [_header endRefreshing];
    }
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
    if (subtype==0)
    {
        return  [titleArray count];
    }
    else
    {
         return [newsArray count];
    }
   
}

-(float)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
    return 100.0f;
}
-(UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *cellIndefiner=@"cellIndefiner";
    NewsCell *cell=(NewsCell *)[tableView dequeueReusableCellWithIdentifier:cellIndefiner];
    if (cell==nil)
    {
        NSArray *xib=[[NSBundle mainBundle]loadNibNamed:@"NewsCell" owner:self options:nil];
        cell=[xib objectAtIndex:0];
        [cell setSelectionStyle:UITableViewCellSelectionStyleNone];
    }
    
    if (subtype==0)
    {
        cell.titleLabel.text=[titleArray objectAtIndex:indexPath.row];
        cell.messageLabel.text=[descriptionArray objectAtIndex:indexPath.row];
        cell.timeLabel.text=[pubDateArray objectAtIndex:indexPath.row];
        
    }
    else
    {
        cell.titleLabel.text=[[newsArray objectAtIndex:indexPath.row] objectForKey:@"title"];
        cell.messageLabel.text=[[newsArray objectAtIndex:indexPath.row] objectForKey:@"subtitle"];
        cell.timeLabel.text=[[[newsArray objectAtIndex:indexPath.row] objectForKey:@"end"] objectForKey:@"date"];
 
    }
    
    /*
    cell.deleteButton.tag=indexPath.row;
    [cell.deleteButton addTarget:self action:@selector(deleteCell:) forControlEvents:UIControlEventTouchUpInside];
     */
    
    return cell;
    
}

-(void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    if (subtype==0)
    {
      
        WebViewController *web=[[WebViewController alloc] init];
        web.linking=[linkArray objectAtIndex:indexPath.row];
        web.title=self.title;
        web.type=2;
        [self.navigationController pushViewController:web animated:YES];
        [web release];
        
        
    }
    else
    {
        newsInfo.frame=CGRectMake(0, 460+(iPhone5?88:0),WIDTH, 460+(iPhone5?88:0));
        [newsInfo setContent:[[newsArray objectAtIndex:indexPath.row] objectForKey:@"text"]];
        
        [UIView animateWithDuration:.5 animations:^{
            newsInfo.frame = CGRectMake(0, 10,WIDTH, 400+(iPhone5?88:0));
        }completion:^(BOOL finished) {
        }];
    }
}

//去除弹出页面
-(void)dissmissInfoPage
{
    [UIView animateWithDuration:.5 animations:^{
        newsInfo.frame = CGRectMake(0, -600,WIDTH,416+(iPhone5?88:0));
    }completion:^(BOOL finished) {
    }];
    
}

/*
//删除行
-(void)deleteCell:(id)sender
{
    NSLog(@"123456");
    
    deleteNum=[sender tag];
    UIAlertView *alert=[[UIAlertView alloc]initWithTitle:@"Prompt"
                                                 message:@"are you sure to delete this message"
                                                delegate:self
                                       cancelButtonTitle:@"cancel"
                                       otherButtonTitles:@"confirm", nil];
    
    [alert show];
    [alert release];
    
   
}

-(void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex
{
    if (buttonIndex==1)
    {
        [newsArray removeObjectAtIndex:deleteNum];
        NSIndexPath *path = [NSIndexPath indexPathForRow:deleteNum inSection:0];
        
        [newsTableView deleteRowsAtIndexPaths:[NSArray arrayWithObject:path] withRowAnimation:UITableViewRowAnimationLeft];
    }
}

*/

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


//解析xml
-(void)parserDidStartDocument:(NSXMLParser *)parser
{
    tempString=nil;
    //[ToolLen ShowWaitingView:YES];
    
}

- (void)parser:(NSXMLParser *)parser didStartElement:(NSString *)elementName namespaceURI:(NSString *)namespaceURI qualifiedName:(NSString *)qName attributes:(NSDictionary *)attributeDict
{
    //NSLog(@"elementName::%@",elementName);
    
    if([elementName isEqualToString:@"title"])
    {
        if (titleArray==nil)
        {
            titleArray = [[NSMutableArray alloc]init];
        }
    }
    else if([elementName isEqualToString:@"description"])
    {
        if (descriptionArray==nil)
        {
            descriptionArray = [[NSMutableArray alloc]init];
        }
    }
    else if([elementName isEqualToString:@"link"])
    {
        if (linkArray==nil)
        {
            linkArray = [[NSMutableArray alloc]init];
        }
    }
    else if([elementName isEqualToString:@"pubDate"])
    {
        if (pubDateArray==nil)
        {
            pubDateArray = [[NSMutableArray alloc]init];
        }
    }
    
}

//获取内容
- (void)parser:(NSXMLParser *)parser foundCharacters:(NSString *)string
{
     //NSLog(@"string::%@",string);
    
    if(tempString == nil)
    {
        tempString = [[NSMutableString alloc]init];
    }
   
    [tempString appendString:string];
}
//结束解析元素
- (void)parser:(NSXMLParser *)parser didEndElement:(NSString *)elementName namespaceURI:(NSString *)namespaceURI qualifiedName:(NSString *)qName
{
    
   if([elementName isEqualToString:@"title"])
    {
        NSString *headerData=(NSString *)tempString;
        headerData = [headerData stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceAndNewlineCharacterSet]];  //去除掉首尾的空白字符和换行字符
        headerData = [headerData stringByReplacingOccurrencesOfString:@"\r" withString:@""];
        headerData = [headerData stringByReplacingOccurrencesOfString:@"\n" withString:@""];
        
        [titleArray addObject:headerData];
        
    }
    else if([elementName isEqualToString:@"description"])
    {
        NSString *headerData=(NSString *)tempString;
        headerData = [headerData stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceAndNewlineCharacterSet]];  //去除掉首尾的空白字符和换行字符
        headerData = [headerData stringByReplacingOccurrencesOfString:@"\r" withString:@""];
        headerData = [headerData stringByReplacingOccurrencesOfString:@"\n" withString:@""];
        
        [descriptionArray addObject:headerData];
    }
    else if([elementName isEqualToString:@"link"])
    {
        NSString *headerData=(NSString *)tempString;
        headerData = [headerData stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceAndNewlineCharacterSet]];  //去除掉首尾的空白字符和换行字符
        headerData = [headerData stringByReplacingOccurrencesOfString:@"\r" withString:@""];
        headerData = [headerData stringByReplacingOccurrencesOfString:@"\n" withString:@""];

        
        [linkArray addObject:headerData];
    }
    else if([elementName isEqualToString:@"pubDate"])
    {
        NSString *headerData=(NSString *)tempString;
        headerData = [headerData stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceAndNewlineCharacterSet]];  //去除掉首尾的空白字符和换行字符
        headerData = [headerData stringByReplacingOccurrencesOfString:@"\r" withString:@""];
        headerData = [headerData stringByReplacingOccurrencesOfString:@"\n" withString:@""];
        
        [pubDateArray addObject:headerData];
    }
    
    
    tempString = nil;
}

//解析并刷新列表，解析到document的尾部时，会调用这个方法
-(void)parserDidEndDocument:(NSXMLParser *)parser
{
    [ToolLen ShowWaitingView:NO];
    //解析结束
    //[productTableView reloadData];
  //  NSLog(@"titleArray::%@",titleArray);
    
    
    [titleArray removeObjectAtIndex:0];
    [titleArray removeObjectAtIndex:0];
    [linkArray removeObjectAtIndex:0];
    [linkArray removeObjectAtIndex:0];
    [descriptionArray removeObjectAtIndex:0];
    
    
   // NSLog(@"link::%@",linkArray);
    
    [newsTableView reloadData];
    
    // 结束刷新状态
    [_header endRefreshing];
}



@end
