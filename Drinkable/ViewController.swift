//
//  ViewController.swift
//  Drinkable
//
//  Created by Pavlos Nicolaou on 10/09/2016.
//  Copyright © 2016 Pavlos Nicolaou. All rights reserved.
//

import UIKit
import MapKit

class ViewController: UIViewController, MKMapViewDelegate, CLLocationManagerDelegate {

    
    @IBOutlet weak var mapView: MKMapView!
    @IBOutlet weak var resultLbl: UILabel!
    
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
        let latDelta:CLLocationDegrees = 0.001
        let longDelta:CLLocationDegrees = 0.001
        let theSpan = MKCoordinateSpan(latitudeDelta: latDelta, longitudeDelta: longDelta)
        
        let theRegion = MKCoordinateRegion(center: coordinate, span: theSpan)
        
        if compareRegion(region: theRegion, coordinate: coordinate) && clean == 1 {
            print("PAV: The water is clean")
            self.resultLbl.text = "Water is drinkable!"
        } else if compareRegion(region: theRegion, coordinate: coordinate) && clean == 0 {
            print("PAV: The water is NOT clean")
            self.resultLbl.text = "Water is NOT drinkable!"
        } else {
            print("PAV: no info for water")
            self.resultLbl.text = "No info for drinkable water!"
        }
    }
    
    func compareRegion(region : MKCoordinateRegion, coordinate : CLLocationCoordinate2D) -> Bool {
        
        let center   = region.center;
        let northWestCorner = CLLocationCoordinate2D(latitude: center.latitude  - (region.span.latitudeDelta  / 2.0), longitude: center.longitude - (region.span.longitudeDelta / 2.0))
        let southEastCorner = CLLocationCoordinate2D(latitude: center.latitude  + (region.span.latitudeDelta  / 2.0), longitude: center.longitude + (region.span.longitudeDelta / 2.0))
        //printing results
        print("PAV",  coordinate.latitude  >= northWestCorner.latitude &&
            coordinate.latitude  <= southEastCorner.latitude &&
            
            coordinate.longitude >= northWestCorner.longitude &&
            coordinate.longitude <= southEastCorner.longitude
        )
        return (
            coordinate.latitude  >= northWestCorner.latitude &&
                coordinate.latitude  <= southEastCorner.latitude &&
                
                coordinate.longitude >= northWestCorner.longitude &&
                coordinate.longitude <= southEastCorner.longitude
        )
    }
}

