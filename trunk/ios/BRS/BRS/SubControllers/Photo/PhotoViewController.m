//
//  PhotoViewController.m
//  BRS
//
//  Created by cgx on 13-10-28.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import "PhotoViewController.h"

@interface PhotoViewController ()

@end

@implementation PhotoViewController
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
    
    [self updateIcon:nil];//更新图标
    
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
       // NSLog(@"url::%@",urlLinking);
       
        [self WebdefaultView:urlLinking];
        
    }
    else
    {
        photoTableView=[[UITableView alloc]initWithFrame:CGRectMake(0,0, WIDTH, 416+(iPhone5?88:0))];
        photoTableView.separatorStyle=UITableViewCellSeparatorStyleNone;
        photoTableView.backgroundView=nil;
        photoTableView.backgroundColor=[UIColor clearColor];
        photoTableView.delegate=self;
        photoTableView.dataSource=self;
        
        [self.view addSubview:photoTableView];
        [photoTableView release];
        
        // 下拉刷新
        _header = [[MJRefreshHeaderView alloc] init];
        _header.scrollView =photoTableView;
        _header.delegate = self;
        
    }
}


//上拉更新加载更多数据
#pragma mark - 刷新的代理方法---进入下拉刷新\上拉加载更多都有可能调用这个方法
- (void)refreshViewBeginRefreshing:(MJRefreshBaseView *)refreshView
{
    if(refreshView==_header)//刷新首页
    {
       [[self requestFactory] commonRequest:Resource type:@"2" info:nil];
        
    }
}


-(void)viewDidAppear:(BOOL)animated
{
    if (subtype==1)
    {
        //接口请求
        [ToolLen ShowWaitingView:YES];
        
        [[self requestFactory] commonRequest:Resource type:@"2" info:nil];

    }
}

-(void)responseSuccess:(NSDictionary *)dic
{
    [ToolLen ShowWaitingView:NO];
   //  NSLog(@"dic::%@",dic);
    photoArray=[[NSArray alloc] initWithArray:(NSArray *)dic];
    
    [photoTableView reloadData];
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
    if ([photoArray count]%2==0)
    {
        return [photoArray count]/2;
    }
    else
    {
        return [photoArray count]/2+1;
    }
    
}

-(CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
    return 120.0;
}
-(UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *cellIndefiner=@"cellIndefiner";
    PhotoCell *cell=(PhotoCell *)[tableView dequeueReusableCellWithIdentifier:cellIndefiner];
    if (cell==nil)
    {
        NSArray *xib=[[NSBundle mainBundle]loadNibNamed:@"PhotoCell" owner:self options:nil];
        cell=[xib objectAtIndex:0];
        [cell setSelectionStyle:UITableViewCellSelectionStyleNone];
    }
    if ([photoArray count]%2==0)
    {
        [cell.image1 loadImage:[NSString stringWithFormat:@"%@%@",[AppDelegate setGlobal].baseUrl,[[photoArray objectAtIndex:2*indexPath.row] objectForKey:@"path"]]];
        [cell.image2 loadImage:[NSString stringWithFormat:@"%@%@",[AppDelegate setGlobal].baseUrl,[[photoArray objectAtIndex:2*indexPath.row+1] objectForKey:@"path"]]];
        
        cell.button1.tag=2*indexPath.row;
        [cell.button1 addTarget:self action:@selector(clickImage:) forControlEvents:UIControlEventTouchUpInside];
        
        cell.button2.tag=2*indexPath.row+1;
        [cell.button2 addTarget:self action:@selector(clickImage:) forControlEvents:UIControlEventTouchUpInside];
        
        
    }
    else
    {
        
    
        if (indexPath.row<[photoArray count]/2)
        {
            [cell.image1 loadImage:[NSString stringWithFormat:@"%@%@",[AppDelegate setGlobal].baseUrl,[[photoArray objectAtIndex:2*indexPath.row] objectForKey:@"path"]]];
            [cell.image2 loadImage:[NSString stringWithFormat:@"%@%@",[AppDelegate setGlobal].baseUrl,[[photoArray objectAtIndex:2*indexPath.row+1] objectForKey:@"path"]]];
            
            cell.button1.tag=2*indexPath.row;
            [cell.button1 addTarget:self action:@selector(clickImage:) forControlEvents:UIControlEventTouchUpInside];
            
            cell.button2.tag=2*indexPath.row+1;
            [cell.button2 addTarget:self action:@selector(clickImage:) forControlEvents:UIControlEventTouchUpInside];
            
        }
        else
        {
             [cell.image1 loadImage:[NSString stringWithFormat:@"%@%@",[AppDelegate setGlobal].baseUrl,[[photoArray objectAtIndex:2*indexPath.row] objectForKey:@"path"]]];
            cell.button1.tag=2*indexPath.row;
            [cell.button1 addTarget:self action:@selector(clickImage:) forControlEvents:UIControlEventTouchUpInside];
            
            cell.image2.image=nil;
        }
        

    }
    return cell;
    
}


-(void)clickImage:(id)sender
{
    ImagesViewController *images=[[ImagesViewController alloc] init];
    images.imageArr=[NSArray arrayWithArray:photoArray];
    
    [self.navigationController pushViewController:images animated:YES];
    [images release];
    
}



//返回上一级
-(void)backPreviousPage
{
    [self.navigationController popViewControllerAnimated:YES];
}


- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
