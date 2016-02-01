//
//  CustomNavigationController.m
//  AnCheXin
//
//  Created by cgx on 13-11-6.
//  Copyright (c) 2013年 LianJia. All rights reserved.
//

#import "CustomNavigationController.h"
#import <QuartzCore/QuartzCore.h>

@interface CustomNavigationController ()

@end

@implementation CustomNavigationController

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
    
    
    if ([self.navigationBar respondsToSelector:@selector(setBackgroundImage:forBarMetrics:)])
    {
        
        [[UINavigationBar appearance] setBackgroundImage:[UIImage imageNamed:@"navigationBarBg"] forBarMetrics:UIBarMetricsDefault];
        self.navigationBar.translucent=NO;//不透明
        
        NSShadow *shadow = [[NSShadow alloc] init];
        shadow.shadowColor = [UIColor colorWithRed:0.0 green:0.0 blue:0.0 alpha:0.8];
        shadow.shadowOffset = CGSizeMake(0, 0);
        [[UINavigationBar appearance] setTitleTextAttributes: [NSDictionary dictionaryWithObjectsAndKeys:[UIColor colorWithRed:245.0/255.0 green:245.0/255.0 blue:245.0/255.0 alpha:1.0], NSForegroundColorAttributeName,[UIFont fontWithName:@"HelveticaNeue-CondensedBlack" size:18.0], NSFontAttributeName, nil]];
        
    }
    
    /*
    self.navigationBar.translucent=NO;//不透明
    
    //设置为UIRectEdgeNone,即从导航栏下面计算，（0，0）。
    self.edgesForExtendedLayout = UIRectEdgeNone;
  

    NSShadow *shadow = [[NSShadow alloc] init];
    shadow.shadowColor = [UIColor colorWithRed:0.0 green:0.0 blue:0.0 alpha:0.8];
    shadow.shadowOffset = CGSizeMake(0, 0);
    [[UINavigationBar appearance] setTitleTextAttributes: [NSDictionary dictionaryWithObjectsAndKeys:[UIColor whiteColor], NSForegroundColorAttributeName,[UIFont fontWithName:@"HelveticaNeue-CondensedBlack" size:18.0], NSFontAttributeName, nil]];
     */
    
    
}

//重写push方法
- (void)pushViewController:(UIViewController *)viewController animated:(BOOL)animated
{
    [super pushViewController:viewController animated:animated];
    
    if (viewController.navigationItem.leftBarButtonItem== nil && [self.viewControllers count] > 1 )
    {
         viewController.navigationItem.leftBarButtonItem =[self customLeftBackButton];//重新定义左按钮
    }
    
}


-(UIBarButtonItem*)customLeftBackButton
{
    
    UIImage *image=IMAGE(@"left_button");//返回按钮的背景
    UIButton *btn=[UIButton buttonWithType:UIButtonTypeCustom];
    btn.frame=CGRectMake(0, 10, 25, 20);
    [btn setBackgroundImage:image forState:UIControlStateNormal];
    [btn addTarget:self action:@selector(popself) forControlEvents:UIControlEventTouchUpInside];
    UIBarButtonItem *backItem = [[UIBarButtonItem alloc] initWithCustomView:btn];
    
    return backItem;
}

-(void)popself
{
    [self popViewControllerAnimated:YES];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
