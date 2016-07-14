import {Component} from '@angular/core';
import {Platform, ionicBootstrap, MenuController} from 'ionic-angular';
import {StatusBar} from 'ionic-native';
import {HomePage} from './pages/home/home';
import {SearchPage} from './pages/search/search';
import {SightingsService} from './services/sightings-service';
import {PokemonService} from './services/pokemon-service';

@Component({
  templateUrl: 'build/app.html',
	providers: [SightingsService, PokemonService]
})
export class MyApp {

  private rootPage = HomePage;
	private SearchPage = SearchPage;
	private HomePage = HomePage;

  constructor(private platform:Platform, private menu:MenuController) {
    platform.ready().then(() => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      StatusBar.styleDefault();
    });
  }

	openPage(page) {
		this.rootPage = page;
		this.menu.close();
	}
}

ionicBootstrap(MyApp)
