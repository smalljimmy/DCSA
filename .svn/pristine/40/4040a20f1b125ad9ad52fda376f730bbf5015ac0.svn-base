//
//  FormViewController.m
//  BRS
//
//  Created by cgx on 13-10-28.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import "FormViewController.h"

@interface FormViewController ()

@end

@implementation FormViewController
@synthesize subtype;
@synthesize lagCode;
@synthesize urlLinking;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}




//刷新视图
-(void)freshView
{
    [defaultView removeFromSuperview];
    /*
    // NSString *contentStr=[NSString stringWithFormat:@"%@\n%@\n%@\n%@\n\noffice: %@\nfax: %@\nemail: %@\n",@"DC Design+Consulting Sa",@"Seewenstrasse 11",@"6440 Brunnen",@"Schweiz",[[AppDelegate setGlobal].configDic objectForKey:@"fax"],[[AppDelegate setGlobal].configDic objectForKey:@"fax"],[[AppDelegate setGlobal].configDic objectForKey:@"offerEmail"]];
    
     CGSize constraint = CGSizeMake(180.0f, 20000.0f);
     CGSize size = [contentStr sizeWithFont:[UIFont systemFontOfSize:13.0] constrainedToSize:constraint lineBreakMode:NSLineBreakByWordWrapping];
     CGFloat height = MAX(size.height, 20.0f);
     
     UIView *infoMessage=[[UIView alloc]initWithFrame:CGRectMake(20, NAVBARHEIGHT +30, 180, height+20)];
     infoMessage.backgroundColor=[UIColor clearColor];
     
     UIImageView *imageview=[[UIImageView alloc] initWithFrame:CGRectMake(0, 10, 180, height+20)];
     imageview.image=IMAGE(@"newcell_bg");
     [infoMessage addSubview:imageview];
     [imageview release];
     
     
     UILabel *label=[[UILabel alloc] initWithFrame:CGRectMake(10, 10, 180, height+20)];
     label.backgroundColor=[UIColor clearColor];
     label.font=[UIFont systemFontOfSize:13.0];
     label.textAlignment=UITextAlignmentLeft;
     label.textColor=[UIColor darkGrayColor];
     [label setNumberOfLines:0];//将label的行数设置为0，可以自动适应行数
     [label setLineBreakMode:NSLineBreakByWordWrapping];//label可换行
     label.text=contentStr;
     [infoMessage addSubview:label];
     [label release];
     
     [self.view addSubview:infoMessage];
     [infoMessage release];
     */
    
    
    
    //Label
    UILabel *imailAddress=[[UILabel alloc] initWithFrame:CGRectMake(10, 180+(iPhone5?30:0), 100, 20)];
     imailAddress.backgroundColor=[UIColor clearColor];
     imailAddress.font=[UIFont systemFontOfSize:15.0];
     imailAddress.textAlignment=UITextAlignmentRight;
     imailAddress.textColor=[UIColor darkGrayColor];
     imailAddress.text=@"Emailaddress:";
     [self.view addSubview:imailAddress];
     [imailAddress release];
    
    //label
     UIImageView *emImg=[[UIImageView alloc]initWithFrame:CGRectMake(115, 180+(iPhone5?30:0), 180, 30)];
     emImg.image=IMAGE(@"textField_1");
     [self.view addSubview:emImg];
     [emImg release];
    
    textField=[[UITextField alloc] initWithFrame:CGRectMake(115, 182+(IOS7?0:3)+(iPhone5?30:0), 180, 30)];
     textField.delegate=self;
     textField.backgroundColor=[UIColor clearColor];
     //textField.text=@"123456";
     textField.font=[UIFont systemFontOfSize:14.0];
     textField.textColor=[UIColor blackColor];
     [self.view addSubview:textField];
     [textField release];
    
    //label
     UILabel *anliegen=[[UILabel alloc] initWithFrame:CGRectMake(10, 245+(iPhone5?30:0), 100, 20)];
     anliegen.backgroundColor=[UIColor clearColor];
     anliegen.font=[UIFont systemFontOfSize:14.0];
     anliegen.textAlignment=UITextAlignmentRight;
     anliegen.textColor=[UIColor darkGrayColor];
     anliegen.text=@"Ihr Anliegen:";
     [self.view addSubview:anliegen];
     [anliegen release];
    
    UIImageView *IhrImg=[[UIImageView alloc]initWithFrame:CGRectMake(115, 245+(iPhone5?30:0), 180,100)];
    IhrImg.image=IMAGE(@"textViewbg");
    [self.view addSubview:IhrImg];
    [IhrImg release];
    
     textView=[[UITextView alloc] initWithFrame:CGRectMake(115, 245+(iPhone5?30:0), 180, 100+(iPhone5?88:0))];
     textView.backgroundColor=[UIColor clearColor];
     textView.delegate=self;
     [self.view addSubview:textView];
     [textView release];
    
    //提交
     UIButton *button=[UIButton buttonWithType:UIButtonTypeRoundedRect];
     button.frame=CGRectMake(120, 365+(iPhone5?50:0), 100, 35);
     [button setBackgroundImage:IMAGE(@"buttonbg") forState:UIControlStateNormal];
     [button addTarget:self action:@selector(upLoad) forControlEvents:UIControlEventTouchUpInside];
     [self.view addSubview:button];
    
    
    NSString *content=[[[[[AppDelegate setGlobal].configDic objectForKey:@"contactSubmitMsg"] objectForKey:lagCode] objectAtIndex:0] objectForKey:@"content"];
    
     newsInfo=[[NewsInfoView alloc]initWithFrame:CGRectMake(0, 460+(iPhone5?88:0),WIDTH, 460+(iPhone5?88:0))type:@"form" content:content];
     newsInfo.delegate=self;
     [self.view addSubview:newsInfo];

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
        [self WebdefaultView:urlLinking];//显示默认的WEB
    }
    else
    {
         [self freshView];//刷新页面
    }
}




-(BOOL)textFieldShouldReturn:(UITextField *)textField1
{
    [UIView animateWithDuration:.5 animations:^{
        self.view.center=CGPointMake(160, self.view.frame.size.height/2+64);
    }completion:^(BOOL finished){
        [textField resignFirstResponder];//隐藏键盘
        
    }];
    
    return YES;
}

-(void)textFieldDidBeginEditing:(UITextField *)textField
{
    [UIView animateWithDuration:.5 animations:^{
        self.view.center=CGPointMake(160, 100);
    }completion:^(BOOL finished) {
    }];
    
}
-(void)textViewDidBeginEditing:(UITextView *)textView
{
    [UIView animateWithDuration:.5 animations:^{
        self.view.center=CGPointMake(160, 80);
    }completion:^(BOOL finished) {
    }];
}

-(BOOL)textView:(UITextView *)textView1 shouldChangeTextInRange:(NSRange)range replacementText:(NSString *)text
{
    if ([text isEqualToString:@"\n"])
    {
        [UIView animateWithDuration:.5 animations:^{
            self.view.center=CGPointMake(160, self.view.frame.size.height/2+64);
        }completion:^(BOOL finished){
            [textView1 resignFirstResponder];
        }];
        
                return NO;
    }
    return YES;
}


//返回上一级
-(void)backPreviousPage
{
    [languageView removeFromSuperview];
    [self.navigationController popViewControllerAnimated:YES];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}



-(void)upLoad
{
    //NSLog(@"提交");
    
    if (textField.text.length>5)
    {
        newsInfo.frame=CGRectMake(0, 460+(iPhone5?88:0),WIDTH, 416+(iPhone5?88:0));
        
        [UIView animateWithDuration:.5 animations:^{
            self.view.center=CGPointMake(160, self.view.frame.size.height/2+44);
        }completion:^(BOOL finished){
            [textView resignFirstResponder];
            [UIView animateWithDuration:.5 animations:^{
                newsInfo.frame = CGRectMake(0, 44,WIDTH, 416+(iPhone5?88:0));
            }completion:^(BOOL finished) {
            }];
            
        }];

    }
    else
    {
        UIAlertView *alert=[[UIAlertView alloc] initWithTitle:nil
                                                      message:@"Emailadresse isterforderlich"
                                                     delegate:nil
                                            cancelButtonTitle:@"sure"
                                            otherButtonTitles: nil];
        [alert show];
        [alert release];
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

@end
