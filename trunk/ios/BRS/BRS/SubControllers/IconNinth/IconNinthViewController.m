//
//  IconNinthViewController.m
//  BRS
//
//  Created by cgx on 13-12-9.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import "IconNinthViewController.h"

@interface IconNinthViewController ()

@end

@implementation IconNinthViewController
@synthesize urlLinking;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}


- (void)test
{
    NSString* input = @"123 abc 中国";
    NSData* data = [input dataUsingEncoding:NSUTF8StringEncoding];
    //NSLog(@"data圆：%@",data);
    
    // 'encrypt', the 'data' buffer is transformed in-place.
    [self transform:data];
    
    // Write the encrypted buffer to a text file.
    [data writeToFile:@"thepath" atomically:YES];
    //NSLog(@"data::%@",data);
    // Try to 'decrypt' the buffer, transformation happens in-place.
    [self transform:data];
    
    // See if it got transformed back ok.
    NSString *result = [[NSString alloc] initWithData:data encoding:NSUTF8StringEncoding];
                        
    // Should print original input string.
    //NSLog(@"Result: %@", result);
          
          
}

-(void)transform:(NSData *)input
{
   	NSString* key = @"0";
    unsigned char* pBytesInput = (unsigned char*)[input bytes];
    unsigned char* pBytesKey = (unsigned char*)[[key dataUsingEncoding:NSUTF8StringEncoding] bytes];
    unsigned int vlen = [input length];
    unsigned int klen = [key length];
    // = 0;
    unsigned int k = vlen % klen;
    unsigned char c;
    for (unsigned int v=0; v < vlen; v++) {
        c = pBytesInput[v] ^ pBytesKey[k];
        pBytesInput[v] = c;
        k = (++k < klen ? k : 0);
    }
}

                              
                              
- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
    //[self hiddenRightButton];//隐藏右边按钮
    [self updateIcon:nil];//更新图标
    [self test];
    
    UIButton *button=[UIButton buttonWithType:UIButtonTypeRoundedRect];
    button.frame=CGRectMake(50, 150, 220, 50);
    [button setTitle:@"发送邮件" forState:UIControlStateNormal];
    [button addTarget:self action:@selector(press:) forControlEvents:UIControlEventTouchUpInside];
    
    [self.view addSubview:button];
    
}


-(void)press:(id)sender
{
    SKPSMTPMessage *testMsg = [[SKPSMTPMessage alloc] init];
   
    testMsg.fromEmail = @"632507854@qq.com"; //发送者邮箱，当前的邮箱必须具有smtp服务
    
    testMsg.toEmail = @"632507854@qq.com";//接收者邮箱

    //testMsg.ccEmail = @"434722544@qq.com";//抄送联系人列表
    //testMsg.bccEmail = @"664742641@qq.com";//密送联系人列表
    
    testMsg.relayHost = @"smtp.qq.com";//发送服务器地址，qq=>smtp.qq.com,163=>smtp.163.com,
    
   
    testMsg.requiresAuth = YES;//默认,需要鉴权
   
    testMsg.login = @"632507854@qq.com"; //发送者的登录账号
    testMsg.pass = @"cgx_lovelife1314";//发送者的登录密码
    
    
    //邮件主题
    testMsg.subject = [NSString stringWithCString:"来自iphone socket的测试邮件" encoding:NSUTF8StringEncoding ];
    testMsg.wantsSecure = YES; // smtp.gmail.com doesn't work without TLS!
    
    // Only do this for self-signed certs!
    // testMsg.validateSSLChain = NO;
    testMsg.delegate = self;//委托代理
    
    
    //主题
    NSDictionary *plainPart = [NSDictionary dictionaryWithObjectsAndKeys:@"text/plain",kSKPSMTPPartContentTypeKey,
                               @"This is a test message.\r\n支持中文。",kSKPSMTPPartMessageKey,@"8bit",kSKPSMTPPartContentTransferEncodingKey,nil];
    
    /*
     //附件
     NSString *vcfPath = [[NSBundle mainBundle] pathForResource:@"video" ofType:@"jpg"];
     NSData *vcfData = [NSData dataWithContentsOfFile:vcfPath];
     
     //附件图片文件
     NSDictionary *vcfPart = [[NSDictionary alloc ]initWithObjectsAndKeys:@"text/directory;\r\n\tx-unix-mode=0644;\r\n\tname=\"video.jpg\"",kSKPSMTPPartContentTypeKey,
     @"attachment;\r\n\tfilename=\"video.jpg\"",kSKPSMTPPartContentDispositionKey,[vcfData encodeBase64ForData],kSKPSMTPPartMessageKey,@"base64",kSKPSMTPPartContentTransferEncodingKey,nil];
     //附件音频文件
     NSString *wavPath = [[NSBundle mainBundle] pathForResource:@"push" ofType:@"wav"];
     NSData *wavData = [NSData dataWithContentsOfFile:wavPath];
     NSDictionary *wavPart = [[NSDictionary alloc ]initWithObjectsAndKeys:@"text/directory;\r\n\tx-unix-mode=0644;\r\n\tname=\"push.wav\"",kSKPSMTPPartContentTypeKey,
     @"attachment;\r\n\tfilename=\"push.wav\"",kSKPSMTPPartContentDispositionKey,[wavData encodeBase64ForData],kSKPSMTPPartMessageKey,@"base64",kSKPSMTPPartContentTransferEncodingKey,nil];
     
     
     testMsg.parts = [NSArray arrayWithObjects:plainPart,vcfPart,wavPart, nil];
     */
    
    
    testMsg.parts = [NSArray arrayWithObjects:plainPart,nil];//传送的内容
    
    [testMsg send];//发送
    

}
//返回上一级
-(void)backPreviousPage
{
    [self.navigationController popViewControllerAnimated:YES];
}


-(void)viewDidAppear:(BOOL)animated
{
    //接口请求
    [ToolLen ShowWaitingView:YES];
    
    [[self requestFactory] commonRequest:Message type:@"7" info:nil];
    
}

-(void)responseSuccess:(NSDictionary *)dic
{
    [ToolLen ShowWaitingView:NO];
    //NSLog(@"dic::%@",dic);
    /*
     if ([dic count]>0)
     {
     newsArray=[[NSMutableArray alloc]initWithArray:(NSArray *)dic];
     
     [newsTableView reloadData];
     }
     */
    
}



#pragma -
#pragma -SKPSMTPMessageDelegate

- (void)messageSent:(SKPSMTPMessage *)message
{
    [message release];
    
    //发送成功
   // NSLog(@"delegate - message sent");
    
    /*
    UIAlertView* alert = [[UIAlertView alloc] initWithTitle:nil
                                                    message:@"发送成功"
                                                   delegate:nil
                                          cancelButtonTitle:@"ok"
                                          otherButtonTitles:nil, nil];
    
    [alert show];
    [alert release];
     */
    
}

- (void)messageFailed:(SKPSMTPMessage *)message error:(NSError *)error
{
    [message release];
    
    //发送失败
    //NSLog(@"delegate - error(%ld): %@", (long)[error code], [error localizedDescription]);
  /*
    UIAlertView* alert = [[UIAlertView alloc] initWithTitle:nil
                                                    message:@"发送失败"
                                                   delegate:nil
                                          cancelButtonTitle:@"ok"
                                          otherButtonTitles:nil, nil];
    
    
    [alert show];
    [alert release];
   */
    
    
}






- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
