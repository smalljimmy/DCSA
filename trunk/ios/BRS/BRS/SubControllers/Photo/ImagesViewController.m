//
//  ImagesViewController.m
//  BRS
//
//  Created by cgx on 14-1-15.
//  Copyright (c) 2014年 DouMob. All rights reserved.
//

#import "ImagesViewController.h"

@interface ImagesViewController ()

@end

@implementation ImagesViewController
@synthesize imageArr;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}


-(void)headView
{

    UIView *headview=[[UIView alloc] initWithFrame:CGRectMake(0, 100, WIDTH, 250)];
    headview.backgroundColor=[UIColor clearColor];
    
    /*
    UIImageView *headImageView=[[UIImageView alloc]initWithFrame:CGRectMake(0, 0, WIDTH,  HEAD_HEIGHT+20+(iPhone5?30:0))];
    headImageView.image=IMAGE(@"index_bg");
    [headview addSubview:headImageView];
    [headImageView release];
     */
    
    
    scrollView1=[[UIScrollView alloc] initWithFrame:CGRectMake(0, 0, WIDTH, 200)];
    scrollView1.delegate=self;
    scrollView1.scrollEnabled=YES;
    scrollView1.pagingEnabled=YES;
    scrollView1.showsHorizontalScrollIndicator=YES;
    scrollView1.showsVerticalScrollIndicator=YES;
    [headview addSubview:scrollView1];
    [scrollView1 release];
    
    
    
    for (int i=0; i<[imageArr count]; i++)
    {
        UIView *view=[[UIView alloc]initWithFrame:CGRectMake(i*WIDTH, 0, WIDTH, 200)];
        view.backgroundColor=[UIColor clearColor];
        
        AsyncImageView *imageView=[[AsyncImageView alloc] initWithFrame:CGRectMake(0, 0, WIDTH, 200)];
        
        [imageView loadImage:[NSString stringWithFormat:@"%@%@",[AppDelegate setGlobal].baseUrl,[[imageArr objectAtIndex:i] objectForKey:@"path"]]];
        
        [view addSubview:imageView];
        [imageView release];
        
        
        [scrollView1 addSubview:view];
        [view release];
        
    }
    
    
    [scrollView1 setContentSize:CGSizeMake(WIDTH *[imageArr count],200)]; //  +上第1页和第4页  原理：4-[1-2-3-4]-1
    [scrollView1 setContentOffset:CGPointMake(0, 0)];
    [scrollView1 scrollRectToVisible:CGRectMake(0,0,WIDTH, 200) animated:NO]; // 默认从序号1位置放第1页 ，序号0位置位置放第4页
    
    
    
    pagecontrolView=[[UILabel alloc]initWithFrame:CGRectMake(0,220, WIDTH,20)];
    pagecontrolView.backgroundColor=[UIColor clearColor];
    pagecontrolView.font=[UIFont systemFontOfSize:14.0];
    pagecontrolView.textAlignment=NSTextAlignmentCenter;
    pagecontrolView.textColor=[UIColor blackColor];
    pagecontrolView.text=[NSString stringWithFormat:@"1 of %lu",(unsigned long)[imageArr count]];
    
    [headview addSubview:pagecontrolView];
    [pagecontrolView release];
    
    
    [self.view addSubview:headview];
    [headview release];
    
    
}




- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
    // [super hiddenRightButton];//隐藏右边的按钮
    
    //NSLog(@"imageDic::%@",imageArr);
    
    [self headView];
    
}


//返回上一级
-(void)backPreviousPage
{
    [self.navigationController popViewControllerAnimated:YES];
}


// scrollview 委托函数
- (void)scrollViewDidEndDecelerating:(UIScrollView *)scrollView
{
    
    CGFloat pagewidth = scrollView1.frame.size.width;
    int currentPage = floor((scrollView1.contentOffset.x - pagewidth/[imageArr count]) / pagewidth) + 1;
    
 
    pagecontrolView.text=[NSString stringWithFormat:@"%d of %lu",currentPage+1,(unsigned long)[imageArr count]];
    
    
}


- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
