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
    
   
    var city: [String] = ["Nicosia", "Strovolos", "Aglantzia", "AgiosDometios", "Egkomi", "Latsia", "Geri", "Tseri", "Ergates", "Anthoupoli", "Alampra", "Sia", "Mathiatis", "AgiaVarvara", "Malounta", "Klirou", "Agios Ioannis ", "Kapedes", "Marki", "Pera Oreinis", "Psimolofou", "Deftera", "Paralimni", "Derineia", "Agia Napa", "Sotira", "Frenaros", "Agios Georgios", "Augorou", "Ksilofagou", "Liopetri", "Oroklini", "Livadia", "Troulloi", "Aradippou", "Kellia", "Kalavasos", "Leukara", "Kofinou", "Vavla", "Zigi", "Naut Vasi", "K.Leukara", "Marwni", "Kornos", "Pyrga", "Peristerona", "Kakopetria", "Platres", "Agros", "Kykkos", "Agios Nikolaos", "Pedoulas"]
    
    var drinkable: [Int] = [2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 2, 2, 2, 2, 2, 0, 0, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 1, 1, 1, 1, 1, 1]
    
    var long: [Double] = [35.1923726, 35.1342857, 35.1450625, 35.1748284, 35.1529251, 35.0959336, 35.0996787, 35.074186, 35.0585592, 35.111885, 34.9913666, 34.9555019, 34.962332, 34.9968629, 35.0326546, 35.0193656, 35.0652139, 34.9767705, 52.3371564, 35.0356089, 35.0609153, 35.0836442, 35.0359701, 35.0834204, 34.9857651, 35.0083582, 35.0545589, 34.6938819, 35.0447389, 34.9752096, 35.0004541, 34.9839531, 34.9541762, 35.0108809, 34.9495243, 34.9834439, 34.7633266, 34.8694114, 34.8382233, 34.8413036, 34.7319042, 34.7242468, 34.8625766, 34.7535014, 34.919644, 34.9016068, 35.1327489, 34.9873709, 34.8879674, 34.920645, 34.9829374, 34.9772308, 34.9671343]
    
    var lat: [Double] = [33.3273606, 33.3107068, 33.3551818, 33.3124707, 33.2897616, 33.3387466, 33.3867349, 33.3067151, 33.219373, 33.2558289, 33.3955861, 33.3847346, 33.3261579, 33.3623489, 33.1719556, 33.1671088, 33.1773805, 33.2445098, 21.0499516, 33.2440678, 33.2457775, 33.2566445, 33.9265706, 33.8635824, 33.9398967, 33.8624558, 33.8687082, 33.0128631, 33.7729684, 33.7726809, 33.8214986, 33.6246661, 33.5985132, 33.5831045, 33.50584, 33.5867651, 33.2235269, 33.284373, 33.3672481, 33.2662312, 33.3290739, 33.2772606, 33.3134813, 33.3513377, 33.3897591, 33.4109412, 33.0661671, 32.8935331, 32.8420752, 32.9859774, 32.7404648, 32.8872934, 32.8249689]
    
    
    
    let locationManager = CLLocationManager()
    var mapHasCenteredOnce = false
    
    
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        
        mapView.delegate = self
        mapView.userTrackingMode = MKUserTrackingMode.follow
        createRegion()
        
        var x = 0
        repeat {
            
            //CLLocationCoordinate2D(latitude: CLLocationDegrees, longitude: CLLocationDegrees)
            
            
            x += 1
        } while (x < city.count)
        
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

