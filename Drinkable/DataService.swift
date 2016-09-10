//
//  DataService.swift
//  Drinkable
//
//  Created by Pavlos Nicolaou on 10/09/2016.
//  Copyright © 2016 Pavlos Nicolaou. All rights reserved.
//

import Foundation
import Firebase

let DB_BASE = FIRDatabase.database().reference()

class DataService {
    
    static let ds = DataService()

    // DB references
    private var _REF_BASE = DB_BASE
    private var _REF_CITIES = DB_BASE.child("Cities")
 
    var REF_BASE: FIRDatabaseReference {
        return _REF_BASE
    }
    
    var REF_CITIES: FIRDatabaseReference {
        return _REF_CITIES
    }
    
    
    func createFirbaseDBCity(uid: String, userData: Dictionary<String, String>) {
        REF_CITIES.child(uid).updateChildValues(userData)
    }


    
}
