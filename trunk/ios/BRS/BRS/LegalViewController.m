//
//  LegalViewController.m
//  BRS
//
//  Created by cgx on 14-2-8.
//  Copyright (c) 2014年 DouMob. All rights reserved.
//

#import "LegalViewController.h"

@interface LegalViewController ()

@end

@implementation LegalViewController
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
    
    //如果类型为0:显示公司信息，1:正常请求链接，data,2:显示网页
    if (subtype==0)
    {
        [self defaultView];
    }
    else if(subtype==2)
    {
         [self WebdefaultView:urlLinking];
    }
    else
    {
        legalTableView=[[UITableView alloc]initWithFrame:CGRectMake(0,0, WIDTH, 416+(iPhone5?88:0))];
        
        legalTableView.separatorStyle=UITableViewCellSeparatorStyleNone;
        legalTableView.backgroundView=nil;
        legalTableView.backgroundColor=[UIColor clearColor];
        legalTableView.delegate=self;
        legalTableView.dataSource=self;
        [self.view addSubview:legalTableView];
        [legalTableView release];
        
    }

    
    
}

-(void)viewDidAppear:(BOOL)animated
{
    //接口请求
    [ToolLen ShowWaitingView:YES];
    
    [[self requestFactory] commonRequest:Resource type:@"5" info:nil];
    
}


-(void)responseSuccess:(NSDictionary *)dic
{
    [ToolLen ShowWaitingView:NO];
    //NSLog(@"dic::%@",dic);
    legalArray=[[NSArray alloc] initWithArray:(NSArray *)dic];
    
    [legalTableView reloadData];
    
}


-(NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return 1;
}

-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return [legalArray count];
}

-(float)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
    return 70.0;
}
-(UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *cellIndefiner=@"cellIndefiner";
    LegalCell *cell=(LegalCell *)[tableView dequeueReusableCellWithIdentifier:cellIndefiner];
    if (cell==nil)
    {
        NSArray *xib=[[NSBundle mainBundle]loadNibNamed:@"LegalCell" owner:self options:nil];
        cell=[xib objectAtIndex:0];
        [cell setSelectionStyle:UITableViewCellSelectionStyleNone];
    }

    //cell.nameLabel.text=[[legalArray objectAtIndex:indexPath.row] objectForKey:@"title"];
    cell.infoLable.text=[[legalArray objectAtIndex:indexPath.row] objectForKey:@"content"];
    
    return cell;
    
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
