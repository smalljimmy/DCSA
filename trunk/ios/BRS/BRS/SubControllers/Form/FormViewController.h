//
//  FormViewController.h
//  BRS
//
//  Created by cgx on 13-10-28.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "NewsInfoView.h"

@interface FormViewController :BaseViewController<UITextFieldDelegate,UITextViewDelegate,NewsInfoDelegate>
{
    NewsInfoView *newsInfo;//提示内容

    UITextView *textView;
    
   
    int  subtype;
    NSString *lagCode;
    
    UITextField *textField;
    
}

@property(nonatomic,assign)int  subtype;
@property(nonatomic,retain)NSString *lagCode;
@property(nonatomic,retain)NSString *urlLinking;

@end
