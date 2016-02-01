//
//  MapViewController.h
//  BRS
//
//  Created by cgx on 13-10-28.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import <UIKit/UIKit.h>

#import <MapKit/MapKit.h>
@interface MapViewController : BaseViewController<MKMapViewDelegate>
{
    MKMapView *_mapView;
    
}

@property(nonatomic,assign) int subtype;
@property(nonatomic,retain) NSString *urlLinking;

@end
