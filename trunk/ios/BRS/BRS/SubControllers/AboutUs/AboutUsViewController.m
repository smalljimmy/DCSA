//
//  AboutUsViewController.m
//  BRS
//
//  Created by cgx on 13-10-28.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import "AboutUsViewController.h"

@interface AboutUsViewController ()

@end

@implementation AboutUsViewController
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


-(void)lengthCalculation:(NSString *)content
{
    NSString *LabelString=content;
    CGSize constraint = CGSizeMake(270.0f, 20000.0f);
    CGSize size = [LabelString sizeWithFont:[UIFont systemFontOfSize:15.0] constrainedToSize:constraint lineBreakMode:NSLineBreakByWordWrapping];
    CGFloat height = MAX(size.height, 20.0f);
  

    UILabel *desLabel=[[UILabel alloc] initWithFrame:CGRectMake(20, 0, 270, height)];
    desLabel.backgroundColor=[UIColor clearColor];
    [desLabel setNumberOfLines:0];//将label的行数设置为0，可以自动适应行数
    [desLabel setLineBreakMode:NSLineBreakByWordWrapping];//label可换行
    [desLabel setFont:[UIFont systemFontOfSize:15.0]];//字体设置为14号
    desLabel.text=LabelString;
    scrollView.contentSize=CGSizeMake(280, height+30);;
    
    [scrollView addSubview:desLabel];
    [desLabel release];
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
        UIView *view=[[UIView alloc] initWithFrame:CGRectMake(0, 150, WIDTH, 310+(iPhone5?88:0))];
        view.backgroundColor=[UIColor colorWithRed:1.0 green:1.0 blue:1.0 alpha:0.8];
        [self.view addSubview:view];
        [view release];
        
        scrollView=[[UIScrollView alloc] initWithFrame:CGRectMake(0, 160, 310,(330+(iPhone5?88:0)+(IOS7?20:0)))];
        scrollView.delegate=self;
        scrollView.scrollEnabled=YES;
        scrollView.pagingEnabled=YES;
        scrollView.showsHorizontalScrollIndicator=NO;
        scrollView.showsVerticalScrollIndicator=YES;
        [self.view addSubview:scrollView];
        [scrollView release];

    }
    
    
}


-(void)viewDidAppear:(BOOL)animated
{
    if (subtype==1)
    {
        //接口请求
        [ToolLen ShowWaitingView:YES];
        
        [[self requestFactory] commonRequest:Resource type:@"3" info:nil];
        
    }
  
    
}

-(void)responseSuccess:(NSDictionary *)dic
{
    [ToolLen ShowWaitingView:NO];
    //NSLog(@"dic::%@",dic);
    
    if ([dic count]>0)
    {
       [self lengthCalculation:[[(NSArray *)dic objectAtIndex:0] objectForKey:@"content"]];
    }
    
    
}

-(void)responseError:(NSDictionary *)dicErr
{
    [ToolLen ShowWaitingView:NO];
    
    
    
}




- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
