//
//  PhotoCell.m
//  BRS
//
//  Created by cgx on 13-10-28.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import "PhotoCell.h"

@implementation PhotoCell
@synthesize image1;
@synthesize image2;
@synthesize button1;
@synthesize button2;

- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {
        // Initialization code
    }
    return self;
}

- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];

    // Configure the view for the selected state
}


-(void)dealloc
{
    [image1 release];
    [image2 release];
    
    [super dealloc];
}
@end
