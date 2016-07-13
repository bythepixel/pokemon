import {Component, AfterViewChecked} from '@angular/core';
import {NavController} from 'ionic-angular';
import {PokemonService} from '../../services/pokemon-service';

declare var google: any;

@Component({
  templateUrl: 'build/pages/home/home.html'
})
export class HomePage {

	map: any;
	heatmapData: any;
	heatmap: any;
	pokemonService: PokemonService;

  constructor(private navController: NavController, pokemonService: PokemonService) {
		this.heatmapData = [
		  new google.maps.LatLng(39.8677588,-105.0668993),
		  new google.maps.LatLng(39.86777,-105.0668993),
		];

		this.pokemonService = pokemonService;
  }

	onPageDidEnter() {
		navigator.geolocation.getCurrentPosition((position) => {
			this.geolocationSuccess(position);
		}, (positionError) => {
			this.geolocationError(positionError);
		});

		this.pokemonService.findAll().subscribe(data => {
			data = JSON.parse(data);
			console.log(data);
			for(var pokemon in data) {
				data[pokemon].sightings.forEach(sighting => {
					this.heatmapData = this.heatmapData.concat([
						  new google.maps.LatLng(sighting.latitude,sighting.longitude),
					])
				});
			}
		});

	}

	geolocationSuccess(position) {

		console.log(position.coords.latitude, position.coords.longitude);
		console.log(this);

		this.map = new google.maps.Map(document.getElementById('map'), {
		  center: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
		  zoom: 20,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		});

		this.heatmap = new google.maps.visualization.HeatmapLayer({
		  data: this.heatmapData
		});
		this.heatmap.setMap(this.map);
	}

	geolocationError(PositionError) {
		console.log(PositionError)
	}
}
