import {Component, AfterViewChecked} from '@angular/core';
import {NavController} from 'ionic-angular';
import {SightingsService} from '../../services/sightings-service';
import {Subscription} from 'rxjs/Subscription';
import {PokemonStateService} from '../../services/pokemon-state-service';
import {Observable} from 'rxjs/Observable';
import {Subject} from 'rxjs/Subject';

declare var google: any;

@Component({
  templateUrl: 'build/pages/home/home.html'
})
export class HomePage {

	map: any;
	heatmapData: any;
	heatmap: any;
	subscription:Subscription
	bounds = new Subject<string>();

  constructor(private navController: NavController, private sightingsService: SightingsService, private pokemonStateService:PokemonStateService) {
		this.heatmapData = [
		  new google.maps.LatLng(39.8677588,-105.0668993),
		  new google.maps.LatLng(39.86777,-105.0668993),
		];

		this.subscription = this.pokemonStateService.activePokemon.subscribe(
			(pokemon) => console.log(pokemon)
		);

		this.bounds.debounceTime(2000)
			.subscribe( results => {
				this.findPokemon();
			});
  }

	ngOnDestroy() {
		this.subscription.unsubscribe();
	}

	onPageDidEnter() {
		navigator.geolocation.getCurrentPosition((position) => {
			this.geolocationSuccess(position);
		}, (positionError) => {
			this.geolocationError(positionError);
		});

	}

	geolocationSuccess(position) {
		let latitude = position.coords.latitude
		let longitude = position.coords.longitude

		this.initMap(latitude, longitude);

		this.findPokemon();
	}

	geolocationError(PositionError) {
		console.log(PositionError)
	}

	findPokemon() {
		this.newMap(this.map.getCenter().lat(), this.map.getCenter().lng(), this.map.getZoom());

		this.sightingsService.findPokemonInView(this.map.getCenter().lat(), this.map.getCenter().lng(), this.map.getZoom(), this.pokemonStateService.activePokemon.getValue()).subscribe( data => {
			let pokemons = JSON.parse(data);
			this.heatmapData = [];
			for(var pokemon in pokemons) {
				let latitudeLongitude = pokemons[pokemon].location.match(/POINT\(((?:-?)\d.+\.\d.+) ((?:-?)\d.+\.\d.+)\)/);
				let latitude = latitudeLongitude[1]
				let longitude = latitudeLongitude[2]
				this.heatmapData = this.heatmapData.concat([
						new google.maps.LatLng(longitude, latitude),
				]);
				}

				this.heatmap = new google.maps.visualization.HeatmapLayer({
					data: this.heatmapData
				});

				this.heatmap.setMap(this.map);
		});

	}

	initMap(latitude, longitude, zoom = 20) {

		this.newMap(latitude, longitude, zoom);

		this.heatmap = new google.maps.visualization.HeatmapLayer({
			data: this.heatmapData
		});

		this.heatmap.setMap(this.map);
	}

	newMap(latitude, longitude, zoom) {

		let app = this;

		this.map = new google.maps.Map(document.getElementById('map'), {
		  center: new google.maps.LatLng(latitude, longitude),
		  zoom: zoom,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		});

		setTimeout(() => {
			this.map.addListener('bounds_changed', function() {
				console.log('bounds');

				app.bounds.next('new')
			})
		}, 2000);
	}
}
