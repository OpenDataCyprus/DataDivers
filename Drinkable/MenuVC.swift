//
//  MenuVC.swift
//  Drinkable
//
//  Created by Pavlos Nicolaou on 11/09/2016.
//  Copyright © 2016 Pavlos Nicolaou. All rights reserved.
//

import UIKit

class MenuVC: UIViewController {

    override func viewDidLoad() {
        super.viewDidLoad()

        let storyboard = UIStoryboard(name: "Menu", bundle: Bundle.main)
        let loginView: MenuVC = storyboard.instantiateViewController(withIdentifier: "MenuVC") as! MenuVC
        UIApplication.shared.keyWindow?.rootViewController = loginView    }

 
}
