import {Component} from '@angular/core';
import {Platform, ionicBootstrap, MenuController} from 'ionic-angular';
import {StatusBar} from 'ionic-native';
import {HomePage} from './pages/home/home';
import {SearchPage} from './pages/search/search';
import {SightingsService} from './services/sightings-service';
import {PokemonService} from './services/pokemon-service';
import {PokemonStateService} from './services/pokemon-state-service';
import {Pokemon} from './entities/pokemon';
import {Subscription} from 'rxjs/Subscription';

@Component({
  templateUrl: 'build/app.html',
	providers: [SightingsService, PokemonService]
})
export class MyApp {

  private rootPage = HomePage;
	private SearchPage = SearchPage;
	private HomePage = HomePage;
	public activePokemon:Pokemon;
	public subscription:Subscription;

  constructor(private platform:Platform, private menu:MenuController, private pokemonStateService:PokemonStateService) {
    platform.ready().then(() => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      StatusBar.styleDefault();
    });
  }

	ngOnInit() {
		this.subscription = this.pokemonStateService.activePokemon.subscribe({
			next: (pokemon) => console.log('unused subsription on app.ts')
		});
	}

	ngOnDestroy() {
		this.subscription.unsubscribe();
	}

	openPage(page) {
		this.rootPage = page;
		this.menu.close();
	}
}

ionicBootstrap(MyApp, [PokemonStateService])
