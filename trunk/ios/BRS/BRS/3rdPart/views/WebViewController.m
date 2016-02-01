//
//  WebViewController.m
//  BRS
//
//  Created by cgx on 14-5-28.
//  Copyright (c) 2014年 DouMob. All rights reserved.
//

#import "WebViewController.h"

@interface WebViewController ()

@end

@implementation WebViewController
@synthesize webDic;
@synthesize linking;
@synthesize type;

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
    self.view.backgroundColor=[UIColor whiteColor];
    
    if (type==1)
    {
        self.title=[webDic objectForKey:@"title"];
        
        UIImage *image=IMAGE(@"left_button");//返回按钮的背景
        UIButton *btn=[UIButton buttonWithType:UIButtonTypeCustom];
        btn.frame=CGRectMake(0, 10, 25, 20);
        [btn setBackgroundImage:image forState:UIControlStateNormal];
        [btn addTarget:self action:@selector(popself) forControlEvents:UIControlEventTouchUpInside];
        UIBarButtonItem *backItem = [[UIBarButtonItem alloc] initWithCustomView:btn];
        
        self.navigationItem.leftBarButtonItem=backItem;
        
        
        UIWebView *web=[[UIWebView alloc]initWithFrame:CGRectMake(0, 0, 320,416+(iPhone5?88:0))];
        web.delegate=self;
        [web setScalesPageToFit:YES];
        [web loadRequest:[NSURLRequest requestWithURL:[NSURL URLWithString:[webDic objectForKey:@"url"]]]];
        [self.view addSubview:web];
        
    }
    else
    {
       // NSLog(@"linking::%@",linking);
        UIWebView *web=[[UIWebView alloc]initWithFrame:CGRectMake(0, 0, 320,416+(iPhone5?88:0))];
        web.delegate=self;
        [web setScalesPageToFit:YES];
        [web loadRequest:[NSURLRequest requestWithURL:[NSURL URLWithString:linking]]];
        [self.view addSubview:web];

    }

  
    
}


#pragma mark －webview的委托代理的实现
-(void)webViewDidStartLoad:(UIWebView *)webView
{
  //  NSLog(@"start");
    [ToolLen ShowWaitingView:NO];
    [UIApplication sharedApplication].networkActivityIndicatorVisible=YES;
    
}
-(void)webViewDidFinishLoad:(UIWebView *)webView
{
   // NSLog(@"success");
    [ToolLen ShowWaitingView:NO];
    [UIApplication sharedApplication].networkActivityIndicatorVisible=NO;
    
}

-(void)webView:(UIWebView *)webView didFailLoadWithError:(NSError *)error
{
  //  NSLog(@"error");
    [ToolLen ShowWaitingView:NO];
    [UIApplication sharedApplication].networkActivityIndicatorVisible=NO;
    /*
    UIAlertView *alert=[[UIAlertView alloc]initWithTitle:@"error"
                                                 message:nil
                                                delegate:nil
                                       cancelButtonTitle:@"确定"
                                       otherButtonTitles: nil];
    [alert show];
    [alert release];
     */
    
}


-(void)popself
{
    [self.navigationController dismissViewControllerAnimated:YES completion:^{
        
    }];
}
- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


@end
