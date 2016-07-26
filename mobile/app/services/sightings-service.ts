import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {Http, Headers} from '@angular/http'
import 'rxjs/add/operator/map';
import {Pokemon} from "../entities/pokemon";
import 'rxjs/add/operator/debounceTime';

@Injectable()
export class SightingsService {
	constructor(public http: Http) {}

	private latitude: number
	private longitude: number
	private zoom: number
	private distance: number

	getState() {
		return {
			latitude: this.latitude,
			longitude: this.longitude,
			zoom: this.zoom,
			distance: this.distance
		}
	}

	setState(latitude:number, longitude:number, zoom:number = 20) {
		this.latitude = latitude
		this.longitude = longitude
		this.zoom = zoom

		// Max zoom of google maps is 21
		this.distance = 21 - zoom
	}

	findPokemonInView(pokemon:Pokemon) {
		return this.http.get("http://192.168.1.8:8080/sightings?latitude=" + this.latitude + "&longitude=" + this.longitude + "&distance=" + this.distance + "&pokemon_id=" + pokemon.id)
			.map(response => response.text());
	}

}
