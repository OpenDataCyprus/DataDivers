//
//  ViewController.swift
//  Drinkable
//
//  Created by Pavlos Nicolaou on 10/09/2016.
//  Copyright © 2016 Pavlos Nicolaou. All rights reserved.
//

import UIKit
import MapKit
import FirebaseDatabase

class ViewController: UIViewController, MKMapViewDelegate, CLLocationManagerDelegate {

    @IBOutlet weak var mapView: MKMapView!
    
    let locationManager = CLLocationManager()
    var mapHasCenteredOnce = false
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        mapView.delegate = self
        mapView.userTrackingMode = MKUserTrackingMode.follow
        createRegion()
        
    }

    override func viewDidAppear(_ animated: Bool) {
        locationAuthStatus()
    }
    
    func locationAuthStatus() {
        if CLLocationManager.authorizationStatus() == .authorizedWhenInUse {
            mapView.showsUserLocation = true
        } else {
            locationManager.requestWhenInUseAuthorization()
        }
    }
    
    func locationManager(_ manager: CLLocationManager, didChangeAuthorization status: CLAuthorizationStatus) {
        if status == CLAuthorizationStatus.authorizedWhenInUse {
            mapView.showsUserLocation = true
        }
    }
    
    func centerMapOnLocation(location: CLLocation) {
        let coordinateRegion = MKCoordinateRegionMakeWithDistance(location.coordinate, 2000, 2000)
        mapView.setRegion(coordinateRegion, animated: true)
    }


    func mapView(_ mapView: MKMapView, didUpdate userLocation: MKUserLocation) {
        if let loc = userLocation.location {
            if !mapHasCenteredOnce {
                centerMapOnLocation(location: loc)
                mapHasCenteredOnce = true
            }
        }
    }
    
    
    func createRegion(){
        //IdeaCy coordinates: 35.171296, 33.361021
        //water is clean
        
        
        // Coordinates
        //we will change the data from google firebase data
        let Lat:CLLocationDegrees = 35.0
        let Long:CLLocationDegrees = 33.0
        let clean = 1
        
        let coordinate = CLLocationCoordinate2D(latitude: Lat, longitude: Long)
        
        //Span
        let latDelta:CLLocationDegrees = 0.01
        let longDelta:CLLocationDegrees = 0.01
        let theSpan = MKCoordinateSpan(latitudeDelta: latDelta, longitudeDelta: longDelta)
        
        let theRegion = MKCoordinateRegion(center: coordinate, span: theSpan)
        
        if compareRegion(location: coordinate, inRegion: theRegion) && clean == 1 {
            print("PAV: The water is clean")
        } else if compareRegion(location: coordinate, inRegion: theRegion) && clean == 0 {
            print("PAV: The water is NOT clean")
        } else {
            print("PAV: no info for water")
        }
    }
    
    func compareRegion(location: CLLocationCoordinate2D, inRegion region: MKCoordinateRegion) -> Bool {
        
        let center = region.center
        let span = region.span
        var result = true
        
        result = cos((center.latitude - location.latitude) * M_PI / 180.0) > cos(span.latitudeDelta / 2.0 * M_PI / 180.0)
        result = cos((center.longitude - location.longitude) * M_PI / 180.0) > cos(span.longitudeDelta / 2.0 * M_PI / 180.0)
        
        print("PAV: We got results")
        return result

    }
    
}

