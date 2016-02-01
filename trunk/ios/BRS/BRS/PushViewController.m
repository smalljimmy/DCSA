//
//  PushViewController.m
//  BRS
//
//  Created by cgx on 14-8-1.
//  Copyright (c) 2014年 DouMob. All rights reserved.
//

#import "PushViewController.h"

@interface PushViewController ()

@end

@implementation PushViewController

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
   // http://stdapp.dataforge.ch/message/ABCDEF/7/1/
    
    self.title=[[AppDelegate setGlobal].configDic objectForKey:@"name"];
    
   
    [ToolLen ShowWaitingView:YES]; //接口请求
    [[self requestFactory] commonRequest:Message type:@"7" info:@"1"];//配置文件
    
    pushTableView=[[UITableView alloc]initWithFrame:CGRectMake(0,0, WIDTH, 416+(iPhone5?88:0))];
    
    pushTableView.separatorStyle=UITableViewCellSeparatorStyleNone;
    pushTableView.backgroundView=nil;
    pushTableView.backgroundColor=[UIColor clearColor];
    pushTableView.delegate=self;
    pushTableView.dataSource=self;
    [self.view addSubview:pushTableView];
    [pushTableView release];

    
    newsInfo=[[NewsInfoView alloc]initWithFrame:CGRectMake(0, 460+(iPhone5?88:0),WIDTH, 460+(iPhone5?88:0))  type:@"news" content:@""];
    
    newsInfo.delegate=self;
    
    [self.view addSubview:newsInfo];
    
}


-(void)responseSuccess:(NSDictionary *)dic
{
  //  NSLog(@"dic::success%@",dic);
    [ToolLen ShowWaitingView:NO];
    
    NSArray *tempArray=[NSArray arrayWithArray:(NSArray *)dic];
    
    NSArray *tempArray1=[document readDataFromDocument:@"BRS_Save" IsArray:YES];
    
   // NSLog(@"tempArray1::%@",tempArray1);
    
    if (tempArray1)
    {
        tempPushArray=[[NSMutableArray alloc] initWithArray:tempArray1];
    }
    else
    {
        tempPushArray=[[NSMutableArray alloc] init];
    }
    
    
    NSDateFormatter *formatter = [[NSDateFormatter alloc] init];
    [formatter setDateFormat:@"YYYY-MM-dd HH:mm:ss"];
    
    for (int i=0; i<[tempArray count]; i++)
    {
        
        NSString *startTimeStr =[[[tempArray objectAtIndex:i] objectForKey:@"start"] objectForKey:@"date"];
        NSDate *startDate = [formatter dateFromString:startTimeStr];
        NSString *startTimeSp = [NSString stringWithFormat:@"%ld", (long)[startDate timeIntervalSince1970]];
       // NSLog(@"startTimeSp::%d",[startTimeSp intValue]);
        
        NSDate *datenow = [NSDate date];//现在时间,你可以输出来看下是什么格式
        //NSString *nowtimeStr = [formatter stringFromDate:datenow];
        NSString *nowTimeSp = [NSString stringWithFormat:@"%ld", (long)[datenow timeIntervalSince1970]];
        //NSLog(@"nowTimeSp:%@",nowTimeSp); //时间戳的值
        
        NSString *endTimeSp=nil;
        
        if ([[[tempArray objectAtIndex:i] objectForKey:@"end"] isKindOfClass:[NSNull class]])
        {
            endTimeSp=@"0";
        }
        else
        {
            NSString *endTime=[[[tempArray objectAtIndex:i] objectForKey:@"end"] objectForKey:@"date"];
            NSDate *endDate = [formatter dateFromString:endTime];
            endTimeSp = [NSString stringWithFormat:@"%ld", (long)[endDate timeIntervalSince1970]];
        }
        
       // NSLog(@"endTimeSp::%@",endTimeSp);
        
        if (([startTimeSp intValue]<=[nowTimeSp intValue] && [nowTimeSp intValue]<=[endTimeSp intValue]) || ([startTimeSp intValue]<=[nowTimeSp intValue]&&[endTimeSp intValue]==0))
        {
            
            int m=0;
            int t=0;
            for (int j=0; j<[tempPushArray count]; j++)
            {
                if ([[[[tempArray objectAtIndex:i] objectForKey:@"uid"] stringValue] isEqualToString:[[[tempPushArray objectAtIndex:j] objectForKey:@"uid"] stringValue]])
                {
                    m=1;
                    t=j;
                    // NSLog(@"雷同");
                    break;
                }
            }
            
            if (m==0)
            {
                //NSLog(@"新增");
                
                NSMutableDictionary *tempDic=[[NSMutableDictionary alloc] init];
                
                [tempDic setObject:[[tempArray objectAtIndex:i] objectForKey:@"uid"] forKey:@"uid"];
                [tempDic setObject:[[tempArray objectAtIndex:i] objectForKey:@"title"] forKey:@"title"];
                [tempDic setObject:[[tempArray objectAtIndex:i] objectForKey:@"subtitle"] forKey:@"subtitle"];
                [tempDic setObject:[[tempArray objectAtIndex:i] objectForKey:@"text"] forKey:@"text"];
                
                NSDateFormatter *dateFormatter = [[NSDateFormatter alloc] init];
                [dateFormatter setDateFormat:@"yyyy-MM-dd HH:mm:ss"];
                NSString *strDate = [dateFormatter stringFromDate:[NSDate date]];
                
                [tempDic setObject:strDate forKey:@"time"];
                
                [tempDic setObject:@"0" forKey:@"isRead"];//是否阅读
                
                [tempPushArray addObject:tempDic];
            }
            else
            {
                if (([startTimeSp intValue]<=[nowTimeSp intValue] && [nowTimeSp intValue]<=[endTimeSp intValue]) || ([startTimeSp intValue]<=[nowTimeSp intValue]&&[endTimeSp intValue]==0))
                {
                 //   NSLog(@"继续保存");
                }
                else
                {
                    [tempPushArray removeObjectAtIndex:t];
                }
            }
        }
        
    }
    
    
    [document saveDataToDocument:@"BRS_Save" fileData:tempPushArray];
    
    pushArray=[[NSMutableArray alloc] init];
    for (int i=[tempPushArray count]-1; i>=0; i--)
    {
        [pushArray addObject:[tempPushArray objectAtIndex:i]];
    }
    
    //NSLog(@"push::%@",pushArray);

    [pushTableView reloadData];
    
}

-(NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return 1;
}

-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    if (pushArray.count>20)
    {
        return 20;
    }
    
    return [pushArray count];
}

-(float)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
    return 100.0;
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
    
    if ([[[pushArray objectAtIndex:indexPath.row] objectForKey:@"isRead"] isEqualToString:@"0"])
    {
        cell.titleLabel.font=[UIFont boldSystemFontOfSize:15.0];
        cell.messageLabel.font=[UIFont boldSystemFontOfSize:13.0];
        cell.timeLabel.font=[UIFont boldSystemFontOfSize:11.0];
        cell.titleLabel.textColor=[UIColor blackColor];
        cell.messageLabel.textColor=[UIColor blackColor];
        cell.messageContentLabel.textColor=[UIColor blackColor];
        cell.timeLabel.textColor=[UIColor blackColor];
    }
    else
    {
        cell.titleLabel.font=[UIFont systemFontOfSize:15.0];
        cell.messageLabel.font=[UIFont systemFontOfSize:13.0];
        cell.timeLabel.font=[UIFont systemFontOfSize:11.0];
        cell.titleLabel.textColor=[UIColor lightGrayColor];
        cell.messageLabel.textColor=[UIColor lightGrayColor];
        cell.messageContentLabel.textColor=[UIColor lightGrayColor];
        cell.timeLabel.textColor=[UIColor lightGrayColor];
        
    }
    
    cell.titleLabel.text=[[pushArray objectAtIndex:indexPath.row] objectForKey:@"title"];
    cell.messageLabel.text=[[pushArray objectAtIndex:indexPath.row] objectForKey:@"subtitle"];
    cell.messageContentLabel.text=[[pushArray objectAtIndex:indexPath.row] objectForKey:@"text"];
    cell.timeLabel.text=[[pushArray objectAtIndex:indexPath.row] objectForKey:@"time"];
    return cell;
    
}


-(void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    newsInfo.frame=CGRectMake(0, 460+(iPhone5?88:0),WIDTH, 460+(iPhone5?88:0));
    [newsInfo setContent:[[pushArray objectAtIndex:indexPath.row] objectForKey:@"text"]];
    
    [UIView animateWithDuration:.5 animations:^{
        newsInfo.frame = CGRectMake(0, 10,WIDTH, 400+(iPhone5?88:0));
    }completion:^(BOOL finished) {
    }];

    
    NSMutableDictionary *temp=[[NSMutableDictionary alloc]initWithDictionary:[pushArray objectAtIndex:indexPath.row]];
    [temp removeObjectForKey:@"isRead"];
    
    [temp setObject:@"1" forKey:@"isRead"];
    
    //NSLog(@"tem::%@",temp);
    
    [pushArray removeObjectAtIndex:indexPath.row];
    [pushArray insertObject:temp atIndex:indexPath.row];
    
   // NSLog(@"pushArray:%@",pushArray);
    
    //倒序，重新写入本地
    NSMutableArray *tempArray=[[NSMutableArray alloc] init];
    for (int i=[pushArray count]-1; i>=0; i--)
    {
        [tempArray addObject:[pushArray objectAtIndex:i]];
    }
    [document saveDataToDocument:@"BRS_Save" fileData:tempArray];
    
    [pushTableView reloadData];
    
    
}

//去除弹出页面
-(void)dissmissInfoPage
{
    [UIView animateWithDuration:.5 animations:^{
        newsInfo.frame = CGRectMake(0, -600,WIDTH,416+(iPhone5?88:0));
    }completion:^(BOOL finished) {
    }];
    
}


- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
