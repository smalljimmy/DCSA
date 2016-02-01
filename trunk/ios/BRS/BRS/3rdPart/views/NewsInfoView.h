//
//  NewsInfoView.h
//  BRS
//
//  Created by cgx on 13-10-28.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import <UIKit/UIKit.h>


@protocol NewsInfoDelegate <NSObject>

-(void)dissmissInfoPage;

@end

@interface NewsInfoView : UIView
{
    UILabel *label;
    id<NewsInfoDelegate> delegate;
    
}

-(void)setContent:(NSString *)content;

- (id)initWithFrame:(CGRect)frame type:(NSString *)type content:(NSString *)content;
@property(nonatomic,retain)id<NewsInfoDelegate> delegate;
@property(nonatomic,retain) NSString *receiveStr;

@end
