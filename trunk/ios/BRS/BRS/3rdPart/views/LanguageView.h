//
//  LanguageView.h
//  BRS
//
//  Created by cgx on 13-10-15.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import <UIKit/UIKit.h>

@protocol LanguageSelectDelegate <NSObject>

-(void)returnSelectLanguage:(int)tag;

@end

@interface LanguageView : UIView
{
    id<LanguageSelectDelegate> delegate;
    
}
@property(nonatomic,retain) id<LanguageSelectDelegate> delegate;


- (id)initWithFrame:(CGRect)frame languageArray:(NSArray *)languageArray;//设置语言界面

@end
