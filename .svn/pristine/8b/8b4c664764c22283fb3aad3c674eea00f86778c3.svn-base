//
//  RootViewController.m
//  BRS
//
//  Created by cgx on 13-10-15.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import "RootViewController.h"

@interface RootViewController ()

@end

@implementation RootViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (NSArray *)themes
{
    return @[@"Documents", @"Gallery", @"About Us",@"Contact",@"News",@"Map",@"Offer"];//
}

//设置首页
-(void)settingGuideView
{
    NSString *languageAd=nil;//语言的简称
    
    for (int i=0; i<[[confDic objectForKey:@"language"] count]; i++)
    {
        if ([languageCode isEqualToString:[[[[confDic objectForKey:@"language"] objectAtIndex:i] objectForKey:@"uid"] stringValue]])
        {
            languageAd=[[[confDic objectForKey:@"language"] objectAtIndex:i] objectForKey:@"code"] ;
           // [languageAd retain];
            break;
        }
    }
    
    bottomView=[[UIView alloc] initWithFrame:CGRectMake(0, 150, WIDTH, 266+(iPhone5?88:0))];
    bottomView.backgroundColor=[UIColor whiteColor];
    for (int i=0; i<3; i++)
    {
        for (int j=0; j<3; j++)
        {
            UIView *view=[[UIView alloc] initWithFrame:CGRectMake(j*107, (89+(iPhone5?29:0))*i, 107,88+(iPhone5?29:0))];
            view.tag=3*i+j+1+500;
            view.backgroundColor=[UIColor clearColor];
            
            [bottomView addSubview:view];
            [view release];
            
            //图标的背景图片
             UIImageView *bgImageView1=[[UIImageView alloc] initWithFrame:CGRectMake(0, 0, 107, 89+(iPhone5?29:0))];
             bgImageView1.image=IMAGE(@"index_default_bg");
             [view addSubview:bgImageView1];
             [bgImageView1 release];
            
            if (confDic)
            {
                if (3*i+j<[[[confDic objectForKey:@"itemName"] objectForKey:languageCode] count]-2)
                {
                    
                     //图标－－icon显示
                    AsyncImageView *iconImageView=[[AsyncImageView alloc] initWithFrame:CGRectMake(28+(iPhone5?0:5), 10+(iPhone5?10:0), 40+(iPhone5?10:0), 40+(iPhone5?10:0))];
                    if (3*i+j+1==5)
                    {
                        iconImageView.tag=3*i+j+2;
                        
                        NSString *iconLink=[NSString stringWithFormat:@"%@icon_%d_%@_act.png",[confDic objectForKey:@"baseURL"],3*i+j+2,languageAd];
                       // NSLog(@"iconLink::%@",iconLink);
                        [iconImageView loadImage:iconLink];
                        
                    }
                   else if (3*i+j+1==6  || 3*i+j+1==7)
                    {
                        iconImageView.tag=3*i+j+3;
                        
                        NSString *iconLink=[NSString stringWithFormat:@"%@icon_%d_%@_act.png",[confDic objectForKey:@"baseURL"],3*i+j+3,languageAd];
                       // NSLog(@"iconLink::%@",iconLink);
                        [iconImageView loadImage:iconLink];
                    }
                    else
                    {
                        iconImageView.tag=3*i+j+1;
                        
                        NSString *iconLink=[NSString stringWithFormat:@"%@icon_%d_%@_act.png",[confDic objectForKey:@"baseURL"],3*i+j+1,languageAd];
                       // NSLog(@"iconLink::%@",iconLink);
                        [iconImageView loadImage:iconLink];
                    }
                   
                    
                    [view addSubview:iconImageView];
                    [iconImageView release];
                    
                  //  NSLog(@"icon::%@",iconImageView.image);
                    if (iconImageView.image==nil)
                    {
                       // NSLog(@"icondddddd");
                        [iconImageView removeFromSuperview];
                        AsyncImageView *iconImageView=[[AsyncImageView alloc] initWithFrame:CGRectMake(28+(iPhone5?0:5), 10+(iPhone5?10:0), 40+(iPhone5?10:0), 40+(iPhone5?10:0))];
                        iconImageView.tag=3*i+j+1;
                        NSString *indexIcon=[NSString stringWithFormat:@"index_default_%d",3*i+j+1];
                        iconImageView.image=IMAGE(indexIcon);
                        [view addSubview:iconImageView];
                        [iconImageView release];
                    }
                    //图标文字
                    UILabel *iconNameLabel=[[UILabel alloc]initWithFrame:CGRectMake(0, 55+(iPhone5?20:0), 106, 20)];
                    iconNameLabel.backgroundColor=[UIColor clearColor];
                    iconNameLabel.font=[UIFont systemFontOfSize:15.0];
                    iconNameLabel.textAlignment=UITextAlignmentCenter;
                    iconNameLabel.textColor=[UIColor darkGrayColor];
                    if (3*i+j+1==5)
                    {
                         iconNameLabel.text=[[[confDic objectForKey:@"itemName"] objectForKey:languageCode] objectForKey:[NSString stringWithFormat:@"%d",3*i+j+2]];//[[self themes] objectAtIndex:3*i+j]
                    }
                    else if (3*i+j+1==6 || 3*i+j+1==7)
                    {
                        iconNameLabel.text=[[[confDic objectForKey:@"itemName"] objectForKey:languageCode] objectForKey:[NSString stringWithFormat:@"%d",3*i+j+3]];//[[self themes] objectAtIndex:3*i+j]
                    }
                    else
                    {
                         iconNameLabel.text=[[[confDic objectForKey:@"itemName"] objectForKey:languageCode] objectForKey:[NSString stringWithFormat:@"%d",3*i+j+1]];//[[self themes] objectAtIndex:3*i+j]
                    }
                   
                    [view addSubview:iconNameLabel];
                    [iconNameLabel release];
                    //按钮－－button
                    UIButton *button=[UIButton buttonWithType:UIButtonTypeCustom];
                    button.frame=view.frame;
                    button.tag=3*i+j+1;
                    button.userInteractionEnabled=YES;
                    [button addTarget:self action:@selector(ClickEnterSubPage:) forControlEvents:UIControlEventTouchUpInside];
                    
                    [bottomView addSubview:button];
                }
            }
            else
            {
                if (3*i+j<[[self themes] count])
                {
                    //显示默认图标图标－－icon显示
                     AsyncImageView *iconImageView=[[AsyncImageView alloc] initWithFrame:CGRectMake(28+(iPhone5?0:5), 10+(iPhone5?10:0), 40+(iPhone5?10:0), 40+(iPhone5?10:0))];
                    iconImageView.tag=3*i+j+1;
                    NSString *indexIcon=[NSString stringWithFormat:@"index_default_%d",3*i+j+1];
                    iconImageView.image=IMAGE(indexIcon);
                    [view addSubview:iconImageView];
                    [iconImageView release];
                    
                    //显示默认文
                    UILabel *iconNameLabel=[[UILabel alloc]initWithFrame:CGRectMake(0, 55+(iPhone5?10:0), 106, 20)];
                    iconNameLabel.backgroundColor=[UIColor clearColor];
                    iconNameLabel.font=[UIFont systemFontOfSize:15.0];
                    iconNameLabel.textAlignment=UITextAlignmentCenter;
                    iconNameLabel.textColor=[UIColor darkGrayColor];
                    iconNameLabel.text=[[self themes] objectAtIndex:3*i+j];//显示默认文字
                    [view addSubview:iconNameLabel];
                    [iconNameLabel release];
   
                    UIButton *button=[UIButton buttonWithType:UIButtonTypeCustom];
                    button.frame=view.frame;
                    button.tag=3*i+j+1;
                    button.userInteractionEnabled=YES;
                    [button addTarget:self action:@selector(ClickEnterSubPage:) forControlEvents:UIControlEventTouchUpInside];
                    [bottomView addSubview:button];
                    
                }
            }
        }
    }
    
    
    for (int i=0; i<3; i++)
    {
        for (int j=0; j<3; j++)
        {
            
            UIImageView *imageView_=[[UIImageView alloc] initWithFrame:CGRectMake(0,(89+(iPhone5?29:0))*i, WIDTH, 1)];
            
            imageView_.image=IMAGE(@"index_default_line_");
            [bottomView addSubview:imageView_];
            [imageView_ release];
            
            if (i!=0)
            {
                
                UIImageView *imageView1=[[UIImageView alloc]initWithFrame:CGRectMake(107*i, 0, 1, 320+(iPhone5?88:0))];
                imageView1.image=IMAGE(@"index_default_line1");
                [bottomView addSubview:imageView1];
                [imageView1 release];
            }
        }
    }
    
    [self.view addSubview:bottomView];
    [bottomView release];
    
}


//推送过来的新消息
-(void)PushView:(id)notifi
{
    //NSLog(@"notifi::%@",[notifi object]);
    
    UIAlertView *messageAlert=[[UIAlertView alloc] initWithTitle:[[[notifi object] objectForKey:@"aps"] objectForKey:@"alert"]
                                                         message:nil
                                                        delegate:self
                                               cancelButtonTitle:@"cancel"
                                               otherButtonTitles:@"yes", nil];
    
    [messageAlert show];
    [messageAlert release];
    
}

-(void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex
{
    if (buttonIndex==1)
    {
        PushViewController *push=[[PushViewController alloc] init];
        [self.navigationController pushViewController:push animated:YES];
        [push release];
    }
}


- (void)viewDidLoad
{
    //[super viewDidLoad];
	// Do any additional setup after loading the view.
    /*
    NSMutableString *friends=nil;
    friends=[NSMutableString stringWithCapacity:50];
    [friends appendString:@"James BethLynn Jack Evan"];
     NSLog(@"前friends::%@",friends);
    NSRange jackRange;
    jackRange=[friends rangeOfString:@"Jack"];
    jackRange.length++;
    
    [friends deleteCharactersInRange:jackRange];
    NSLog(@"后friends::%@",friends);
    */
    
    
    //设置通知
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(refresh) name:@"refresh" object:nil];
    
    //设置通知
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(PushView:) name:@"PushView" object:nil];
    
    UIImage *image=IMAGE(@"index_default_left");
    CGRect frame= CGRectMake(0, 0, 25,25);
	UIButton *button= [[UIButton alloc] initWithFrame:frame];
	[button setBackgroundImage:image forState:UIControlStateNormal];
	[button addTarget:self action:@selector(backPreviousPage) forControlEvents:UIControlEventTouchUpInside];
	UIBarButtonItem *barItem=[[UIBarButtonItem alloc] initWithCustomView:button];
    self.navigationItem.leftBarButtonItem=barItem;
   
    //http://stdapp.dataforge.ch/subscribe/[APN-token]/[languageUID]
    
    homePageScroll=[[UIScrollView alloc] initWithFrame:CGRectMake(0, 0, WIDTH, 150)];
    homePageScroll.delegate=self;
    homePageScroll.scrollEnabled=YES;
    homePageScroll.pagingEnabled=YES;
    homePageScroll.showsHorizontalScrollIndicator=NO;
    homePageScroll.showsVerticalScrollIndicator=NO;
    [self.view addSubview:homePageScroll];
    
    pageControl= [[UIPageControl alloc] initWithFrame:CGRectMake(0, 150-20, WIDTH, 20)];
    pageControl.currentPage=0;
    // 设置非选中页的圆点颜色
    pageControl.pageIndicatorTintColor = [UIColor lightGrayColor];
    // 设置选中页的圆点颜色
    pageControl.currentPageIndicatorTintColor = [UIColor redColor];
    [self.view addSubview:pageControl];
    
    
    flag=0;//表明需要请求接口
   
}

-(void)refresh
{
   // NSLog(@"ttsssss");
    
    flag=0;//表明需要请求接口
   // [self viewDidAppear:YES];
    
    [[self requestFactory] commonRequest:Config type:nil info:nil];//配置文件
    
}
-(void)viewDidAppear:(BOOL)animated
{
    if (flag==0)
    {
        [ToolLen ShowWaitingView:YES]; //接口请求
        [[self requestFactory] commonRequest:Config type:nil info:nil];//配置文件
    }
}

-(void)responseSuccess:(NSDictionary *)dic
{
   // NSLog(@"dic::success%@",dic);
    
    [ToolLen ShowWaitingView:NO];
    
    if ([dic count]>0 && flag==0)
    {
        //？？？？？？state为0或者为1的问题
        if ([[dic objectForKey:@"status"] intValue]==1)//表示获取成功
        {
            if (confDic)
            {
                [confDic release];
                confDic=nil;
                
            }
            confDic=[[NSDictionary alloc] initWithDictionary:dic];//从接口获取配置文件信息
            [AppDelegate setGlobal].configDic=confDic;
            self.title=[confDic objectForKey:@"name"];
            
            languageCode=[[NSString alloc]initWithFormat:@"%@",[[confDic objectForKey:@"langDefault"] stringValue]];//获取语言默认值
            
            [AppDelegate setGlobal].baseUrl=[confDic objectForKey:@"baseURL"];
    
            flag=1;
            
            [ToolLen ShowWaitingView:YES];
            [self settingGuideView];//更新首页
            
            [self updateBanner];//更新banner
            
        }
        else
        {
            if ([[dic objectForKey:@"status"] intValue]==0)//
            {
                UIAlertView *alert=[[UIAlertView alloc] initWithTitle:@"App ist inaktiv"
                                                              message:nil
                                                             delegate:self cancelButtonTitle:@"Bestätigen" otherButtonTitles: nil];
                
                [alert show];
                [alert release];
                
            }
        }

    }
    else if(flag==1 && [(NSArray *)dic count]>0)
    {
        arrCount=[(NSArray *)dic count];
        bannerArray=[[NSArray alloc] initWithArray:(NSArray *)dic];
        
        for (UIView *view in [homePageScroll subviews])
        {
            [view removeFromSuperview];
        }
        
        for (int i=0; i<arrCount; i++)
        {
            UIView *homePageView=[[UIView alloc] initWithFrame:CGRectMake(WIDTH *i,0,WIDTH,150)];
            homePageView.backgroundColor=[UIColor clearColor];
            
            AsyncImageView *image=[[AsyncImageView alloc] initWithFrame:CGRectMake(0, 0, WIDTH, 150)];
   
            [image loadImage:[[(NSArray *)dic objectAtIndex:i]  objectForKey:@"path"]];//设置banner
            
            [homePageView addSubview:image];
            UIButton *button=[UIButton buttonWithType:UIButtonTypeCustom];
            button.frame=image.bounds;
            button.tag=i;
            [button addTarget:self action:@selector(clickBanner:) forControlEvents:UIControlEventTouchUpInside];
            [homePageView addSubview:button];
            [homePageScroll addSubview:homePageView];
        }
        
        [homePageScroll setContentSize:CGSizeMake(WIDTH *arrCount, 150)]; //+上第1页和第4页  原理：4-[1-2-3-4]-1
        [homePageScroll setContentOffset:CGPointMake(0, 0)];
        
        pageControl.numberOfPages=arrCount;
        
        flag=2;
        //上传token
        [[self requestFactory] commonRequest:Config type:[AppDelegate setGlobal].token info:nil];//配置文件
        
        /*
        titleLabel.text=[dicPath objectForKey:@"title"];
        
        
        [AppDelegate setGlobal].updateTitle=[dicPath objectForKey:@"title"];
        [AppDelegate setGlobal].updateBanner=[dicPath objectForKey:@"path"];
         */
        
    }
    else if (flag==2 && dic)
    {
        if ([[AppDelegate setGlobal].push isEqualToString:@"YES"])
        {
            PushViewController *push=[[PushViewController alloc] init];
            [self.navigationController pushViewController:push animated:YES];
            [push release];
        }
    }
}

/*
-(void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex
{
    exit(0);
}
*/


//点击banner弹出网页
-(void)clickBanner:(id)sender
{
    //NSLog(@"sender::%d",[sender tag]);
    WebViewController *web=[[WebViewController alloc] init];
    web.webDic=[bannerArray objectAtIndex:[sender tag]];
    web.type=1;
    CustomNavigationController *navWeb=[[CustomNavigationController alloc] initWithRootViewController:web];
    
    [self.navigationController presentViewController:navWeb animated:YES completion:^{
        
    }];
    
    
}
-(void)scrollViewDidScroll:(UIScrollView *)scrollView
{
    CGFloat pagewidth = scrollView.frame.size.width;
    int currentPage = floor((scrollView.contentOffset.x - pagewidth/arrCount) / pagewidth) + 1;
    
    pageControl.currentPage=currentPage;
    
}


-(void)responseError:(NSDictionary *)dicErr
{
    
}


//更新banner
-(void)updateBanner
{
    [[self requestFactory] commonRequest:Resource type:@"12" info:nil];
}

-(void)backPreviousPage
{
    
  //  NSLog(@"legal");
    LegalViewController *legal=[[LegalViewController alloc] init];
    
    for (int i=0; i<[[confDic objectForKey:@"setup"] count]; i++)
    {
        if ([[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"type"] intValue]==5)
        {
           legal.title=[[[confDic objectForKey:@"itemName"] objectForKey:languageCode] objectForKey:[NSString stringWithFormat:@"%d",5]];
           legal.subtype=[[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"subtype"] intValue];
            
            if (legal.subtype==2)
            {
                legal.urlLinking=[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"data"];
            }
            
            
            break;
        }
        
    }

    
    [self.navigationController pushViewController:legal animated:YES];
    [legal release];
    
    
    
}


//点击进入子页面
-(void)ClickEnterSubPage:(id)sender
{
    NSInteger index=[sender tag];
    
    if (![ToolLen adujestNetwork])
    {
        UIAlertView *alert=[[UIAlertView alloc] initWithTitle:@"prompt" message:@"Your current network is not smooth, please try again later" delegate:nil cancelButtonTitle:@"confirm;" otherButtonTitles:nil];
        [alert show];
        [alert release];
        
        return;
    }
    
    flag=1;//表明返回不需要请求接口
    switch (index)
    {
        case 1:
        {
            //Documents--docs，显示2级页面
            DocsViewController *docs=[[DocsViewController alloc]init];
            
            for (int i=0; i<[[confDic objectForKey:@"setup"] count]; i++)
            {
                if ([[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"type"] intValue]==1)
                {
                    docs.title=[[[confDic objectForKey:@"itemName"] objectForKey:languageCode] objectForKey:[NSString stringWithFormat:@"%d",1]];
                    docs.subtype=[[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"subtype"] intValue];
                    
                    docs.urlLinking=[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"data"];
            
                    break;
                }
                
            }

            
            [self.navigationController pushViewController:docs animated:YES];
            [docs release];
            
            break;
        }
        case 2:
        {
            //Gallery--photo,显示二级页面
            PhotoViewController *photo=[[PhotoViewController alloc]init];
            
            for (int i=0; i<[[confDic objectForKey:@"setup"] count]; i++)
            {
                if ([[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"type"] intValue]==2)
                {
                    photo.title=[[[confDic objectForKey:@"itemName"] objectForKey:languageCode] objectForKey:[NSString stringWithFormat:@"%d",2]];
                    photo.subtype=[[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"subtype"] intValue];
                    
                    photo.urlLinking=[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"data"];
                    
                    break;
                }
                
            }

            
            [self.navigationController pushViewController:photo animated:YES];
            [photo release];
            
            break;
        }
        case 3:
        {
            //AboutUs-- About Us,显示二级页面
            AboutUsViewController *about=[[AboutUsViewController alloc]init];
            
            for (int i=0; i<[[confDic objectForKey:@"setup"] count]; i++)
            {
                if ([[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"type"] intValue]==3)
                {
                     about.title=[[[confDic objectForKey:@"itemName"] objectForKey:languageCode] objectForKey:[NSString stringWithFormat:@"%d",3]];
                    about.subtype=[[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"subtype"] intValue];
                    
                    about.urlLinking=[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"data"];
                   
                    break;
                }
                
            }

            
            [self.navigationController pushViewController:about animated:YES];
            [about release];
            
            break;
        }

        case 4:
        {
            //Contact--Form，判断subtype为0还是1.为0时，显示公司信息。
            
            FormViewController *form=[[FormViewController alloc] init];
            
            for (int i=0; i<[[confDic objectForKey:@"setup"] count]; i++)
            {
                if ([[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"type"] intValue]==4)
                {
                    form.title=[[[confDic objectForKey:@"itemName"] objectForKey:languageCode] objectForKey:[NSString stringWithFormat:@"%d",4]];
                    form.subtype=[[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"subtype"] intValue];
                    
                   
                    form.urlLinking=[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"data"];
                    
                    break;
                }
                
            }
            
            //NSLog(@"languageCode::%@",languageCode);
            form.lagCode=[languageCode retain];
            
            [self.navigationController pushViewController:form animated:YES];
            [form release];
            
            break;
        }
            /*
        case 5:
        {
            //Legal--未确认
            IconEighthViewController *icon_8=[[IconEighthViewController alloc]init];
            [self.navigationController pushViewController:icon_8 animated:YES];
            [icon_8 release];
            
            break;
        }
             */
            
        case 5:
        {
            //News--news
            NewsViewController *news=[[NewsViewController alloc]init];
            
            for (int i=0; i<[[confDic objectForKey:@"setup"] count]; i++)
            {
                if ([[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"type"] intValue]==6)
                {
                    news.title=[[[confDic objectForKey:@"itemName"] objectForKey:languageCode] objectForKey:[NSString stringWithFormat:@"%d",6]];
                    news.subtype=[[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"subtype"] intValue];
                    
                    news.urlLinking=[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"data"];
                    
                    
                    
                    break;
                }
                
            }

            
            [self.navigationController pushViewController:news animated:YES];
            [news release];
            
            break;
        }
        case 6:
        {
            //Map--Map，需要判断subtype是0还是1，是0是需要解析公司信息显示。是1的时候显示地图
             MapViewController *map=[[MapViewController alloc]init];
            for (int i=0; i<[[confDic objectForKey:@"setup"] count]; i++)
            {
                if ([[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"type"] intValue]==8)
                {
                    map.title=[[[confDic objectForKey:@"itemName"] objectForKey:languageCode] objectForKey:[NSString stringWithFormat:@"%d",8]];
                    map.subtype=[[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"subtype"] intValue];
                    map.urlLinking=[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"data"];
                    
                    break;
                }
                
            }
            
            [self.navigationController pushViewController:map animated:YES];
            [map release];
            
            break;
        }
        case 7:
        {
            //Offer--ShopCart//为0时，显示默认地址，为1时显示发送邮件的格式
            ShopCartViewController *shopCart=[[ShopCartViewController alloc]init];
            for (int i=0; i<[[confDic objectForKey:@"setup"] count]; i++)
            {
                if ([[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"type"] intValue]==9)
                {
                    shopCart.title=[[[confDic objectForKey:@"itemName"] objectForKey:languageCode] objectForKey:[NSString stringWithFormat:@"%d",9]];
                    shopCart.subtype=[[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"subtype"] intValue];
                    shopCart.urlLinking=[[[confDic objectForKey:@"setup"] objectAtIndex:i] objectForKey:@"data"];
                    break;
                }
                
            }
        
            shopCart.lagCode=[languageCode retain];
            
            [self.navigationController pushViewController:shopCart animated:YES];
            [shopCart release];
            
            break;
        }
            
        default:
            break;
    }
}

//切换语言
-(void)changeLanguage:(NSString *)language_uid
{
    languageCode=language_uid;//获取语言默认值
    [languageCode retain];
    
    [self settingGuideView];//更新首页
    
    NSString *token=[[NSUserDefaults standardUserDefaults] valueForKey:@"BRStoken"];
    [[self requestFactory] commonRequest:@"subscribe" type:token info:languageCode];//配置文件

}



- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


/*
 for (UIView *subView in  bottomView.subviews)
 {
 if (subView.tag>500)
 {
 // NSLog(@"tag::%@",subView);
 if (subView.tag-500==index)
 {
 for (UIImageView *subImageView in [subView subviews])
 {
 //NSLog(@"subImageView::%@",subImageView);
 if ([subImageView isKindOfClass:[UIImageView class]] && subImageView.tag==index)
 {
 UIImageView *imageView = (UIImageView *)[subImageView viewWithTag:index];
 //NSLog(@"imageView:%@",imageView);
 
 NSString *indexIcon=[NSString stringWithFormat:@"index_default_s_%d",index];
 imageView.image=IMAGE(indexIcon);
 }
 }
 }
 else
 {
 for (UIImageView *subImageView in [subView subviews])
 {
 //NSLog(@"subImageView::%@",subImageView);
 if ([subImageView isKindOfClass:[UIImageView class]] && subImageView.tag>0)
 {
 UIImageView *imageView = (UIImageView *)[subImageView viewWithTag:subImageView.tag];
 //NSLog(@"imageView:%@",imageView);
 
 NSString *indexIcon=[NSString stringWithFormat:@"index_default_%d",subImageView.tag];
 imageView.image=IMAGE(indexIcon);
 }
 }
 
 }
 
 }
 }
 */






@end
