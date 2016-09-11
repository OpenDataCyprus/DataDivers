//
//  InterfaceController.swift
//  DrinkableWatch Extension
//
//  Created by Pavlos Nicolaou on 11/09/2016.
//  Copyright © 2016 Pavlos Nicolaou. All rights reserved.
//

import WatchKit
import Foundation


class InterfaceController: WKInterfaceController {
    @IBOutlet var watchLbl: WKInterfaceLabel!
    
    var Lat1 = 35.172471
    var Long1 = 33.362421
    
    var drinkable: [Int] = [2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 2, 2, 2, 2, 2, 0, 0, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 1, 1, 1, 1, 1, 1]
    
    var long: [Double] = [35.1923726, 35.1342857, 35.1450625, 35.1748284, 35.1529251, 35.0959336, 35.0996787, 35.074186, 35.0585592, 35.111885, 34.9913666, 34.9555019, 34.962332, 34.9968629, 35.0326546, 35.0193656, 35.0652139, 34.9767705, 52.3371564, 35.0356089, 35.0609153, 35.0836442, 35.0359701, 35.0834204, 34.9857651, 35.0083582, 35.0545589, 34.6938819, 35.0447389, 34.9752096, 35.0004541, 34.9839531, 34.9541762, 35.0108809, 34.9495243, 34.9834439, 34.7633266, 34.8694114, 34.8382233, 34.8413036, 34.7319042, 34.7242468, 34.8625766, 34.7535014, 34.919644, 34.9016068, 35.1327489, 34.9873709, 34.8879674, 34.920645, 34.9829374, 34.9772308, 34.9671343]
    
    var lat: [Double] = [33.3273606, 33.3107068, 33.3551818, 33.3124707, 33.2897616, 33.3387466, 33.3867349, 33.3067151, 33.219373, 33.2558289, 33.3955861, 33.3847346, 33.3261579, 33.3623489, 33.1719556, 33.1671088, 33.1773805, 33.2445098, 21.0499516, 33.2440678, 33.2457775, 33.2566445, 33.9265706, 33.8635824, 33.9398967, 33.8624558, 33.8687082, 33.0128631, 33.7729684, 33.7726809, 33.8214986, 33.6246661, 33.5985132, 33.5831045, 33.50584, 33.5867651, 33.2235269, 33.284373, 33.3672481, 33.2662312, 33.3290739, 33.2772606, 33.3134813, 33.3513377, 33.3897591, 33.4109412, 33.0661671, 32.8935331, 32.8420752, 32.9859774, 32.7404648, 32.8872934, 32.8249689]

    
    
    
    override func awake(withContext context: Any?) {
        super.awake(withContext: context)
        
        // Configure interface objects here.
        //self.watchLbl.setText("Medium Quality - The water is NOT drinkable!")
        
        var distance: Double
        var x = 0
        var index=0
        var  min=2500000.0
        
        repeat {
            
            let Lat2:CLLocationDegrees = lat[x]
            let Long2:CLLocationDegrees = long[x]
            
            //efklidia
            let latitude = Lat1 - Lat2
            let longitude = Long1 - Long2
            distance = sqrt(latitude * latitude + longitude * longitude)
            if (distance<min){
                min=distance
                index=x;
                
            }
            x += 1
            
        } while (x < long.count)
        
        print("drinkble",drinkable[index])
        
        if ( drinkable[index] == 1) {
            self.watchLbl.setText("High Quality - Drinkable")
        } else if ( drinkable[index] == 2) {
            self.watchLbl.setText("Medium Quality - Not Drinkable!")
        } else if ( drinkable[index] == 0) {
            self.watchLbl.setText("Low Quality - Not Drinkable!!")
        } else {
            self.watchLbl.setText("No info for Drinkable Water nearby")
        }

    }
    
    override func willActivate() {
        // This method is called when watch view controller is about to be visible to user
        super.willActivate()
    }
    
    override func didDeactivate() {
        // This method is called when watch view controller is no longer visible
        super.didDeactivate()
    }
    
    

}
