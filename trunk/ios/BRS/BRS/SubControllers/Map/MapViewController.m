//
//  MapViewController.m
//  BRS
//
//  Created by cgx on 13-10-28.
//  Copyright (c) 2013年 DouMob. All rights reserved.
//

#import "MapViewController.h"

@interface MapViewController ()

@end

@implementation MapViewController
@synthesize subtype;
@synthesize urlLinking;

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

    [defaultView removeFromSuperview];
    
    //NSLog(@"map::%d",subtype);
    
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
    else
    {
        _mapView=[[MKMapView alloc] initWithFrame:CGRectMake(0, 0, WIDTH, 416+(iPhone5?88:0))];
        _mapView.delegate=self;
        //_mapView.mapType = MKMapTypeHybrid;
        
        float companyLat=[[[AppDelegate setGlobal].configDic objectForKey:@"latitude"] floatValue];//纬度
        float companyLon=[[[AppDelegate setGlobal].configDic objectForKey:@"longitude"] floatValue];//经度
       // currentLatitude::31.7725,currentLongitude::119.944
        //设置经纬度
        //CLLocationCoordinate2D coord = {39.904667,116.408198};
        CLLocationCoordinate2D coord =(CLLocationCoordinate2D){companyLon ,companyLat};
        //CLLocationCoordinate2D coord = {31.7725,119.944};
        //设置显示范围
       // MKCoordinateSpan span = MKCoordinateSpanMake(0.001,0.001);
        
        //设置地图显示的中心和范围
        //MKCoordinateRegion region = MKCoordinateRegionMake(coord,span);
        //根据设置的信息进行显示
       // [_mapView setRegion:region animated:YES];
       // [_mapView sizeToFit];
        
        
        MKCoordinateRegion viewRegion = MKCoordinateRegionMakeWithDistance(coord, 8000, 8000);
        //[mapView setRegion:viewRegion animated:YES];
        MKCoordinateRegion adjustedRegion = [_mapView regionThatFits:viewRegion];
        [_mapView setRegion:adjustedRegion animated:YES];
        
        
        //添加大头针
        MKPointAnnotation *pointAnnotation = nil;
        pointAnnotation = [[MKPointAnnotation alloc] init];
        pointAnnotation.coordinate = coord;
        pointAnnotation.title = [NSString stringWithFormat:@"%@ \t",[[AppDelegate setGlobal].configDic objectForKey:@"name"] ];
        pointAnnotation.subtitle=[NSString stringWithFormat:@"%@ ,%@ %@",[[AppDelegate setGlobal].configDic objectForKey:@"address"], [[AppDelegate setGlobal].configDic objectForKey:@"zip"],[[AppDelegate setGlobal].configDic objectForKey:@"city"]];
        
        [_mapView addAnnotation:pointAnnotation];

        
        
        [self.view addSubview:_mapView];
        [_mapView release];
        
    }
}

#pragma -
#pragma -实现委托代理

- (MKAnnotationView *)mapView:(MKMapView *)mV viewForAnnotation:(id <MKAnnotation>)annotation
{
    MKPinAnnotationView *pinView = nil;
    
    static NSString *defaultPinID = @"com.invasivecode.pin";
    pinView = (MKPinAnnotationView *)[_mapView dequeueReusableAnnotationViewWithIdentifier:defaultPinID];
    
    if ( pinView == nil ) pinView = [[[MKPinAnnotationView alloc]
                                      initWithAnnotation:annotation reuseIdentifier:defaultPinID] autorelease];
    pinView.pinColor = MKPinAnnotationColorRed;
    pinView.canShowCallout = YES;
    pinView.animatesDrop = YES;
    
    
    return pinView;
}



- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
