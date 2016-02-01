//
//  NewsInfoView.m
//  BRS
//
//  Created by cgx on 13-10-28.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import "NewsInfoView.h"

@implementation NewsInfoView
@synthesize delegate;
@synthesize receiveStr;

- (id)initWithFrame:(CGRect)frame type:(NSString *)type content:(NSString *)content
{
    self = [super initWithFrame:frame];
    if (self) {
        // Initialization code

        self.backgroundColor=[UIColor clearColor];
        
        UIView *bgView=nil;;
        if ([type isEqualToString:@"form"])
        {
            bgView=[[UIView alloc] initWithFrame:CGRectMake(10, 80, 300, 200+(iPhone5?88:0))];
        }
        else if([type isEqualToString:@"news"])
        {
             bgView=[[UIView alloc] initWithFrame:CGRectMake(20, 30, 280, 350+(iPhone5?88:0))];
        }
        
        bgView.backgroundColor=[UIColor blackColor];
        bgView.alpha=0.85;
        
        
        NSString *LabelString=content;
        CGSize constraint = CGSizeMake(260.0f, 20000.0f);
        CGSize size = [LabelString sizeWithFont:[UIFont systemFontOfSize:13.0] constrainedToSize:constraint lineBreakMode:NSLineBreakByWordWrapping];
        CGFloat height = MAX(size.height, 20.0f);

        label =[[UILabel alloc]initWithFrame:CGRectMake(10, 20, 250 ,height)];
        label.backgroundColor=[UIColor clearColor];
        [label setNumberOfLines:0];//将label的行数设置为0，可以自动适应行数
        [label setLineBreakMode:NSLineBreakByWordWrapping];//label可换行
        label.font=[UIFont systemFontOfSize:13.0];
        label.textColor=[UIColor whiteColor];
        label.text=LabelString;
        [bgView addSubview:label];
        [label release];
        
        UIView *buttonView=[[UIView alloc] initWithFrame:CGRectMake(250, 10, 25, 25)];
        buttonView.backgroundColor=[UIColor clearColor];
        
        UIImageView *imageView=[[UIImageView alloc] initWithFrame:CGRectMake(0, 0, 25, 25)];
        imageView.image=IMAGE(@"newsinfo_button");
        [buttonView addSubview:imageView];
        [imageView release];
        
        UIButton *button=[UIButton buttonWithType:UIButtonTypeCustom];
        button.frame=CGRectMake(0, 0, 25, 25);
        [button addTarget:self action:@selector(dissMissSubView) forControlEvents:UIControlEventTouchUpInside];
        [buttonView addSubview:button];
        
        [bgView addSubview:buttonView];
        [buttonView release];
        
        [self addSubview:bgView];
        [bgView release];
        
    }
    return self;
}


-(void)setContent:(NSString *)content
{
    label.text=content;
}
//页面消失
-(void)dissMissSubView
{
    if ([delegate respondsToSelector:@selector(dissmissInfoPage)])
    {
        [delegate dissmissInfoPage];
    }
}
/*
// Only override drawRect: if you perform custom drawing.
// An empty implementation adversely affects performance during animation.
- (void)drawRect:(CGRect)rect
{
    // Drawing code
}
*/

@end
