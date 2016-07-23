import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {Http, Headers} from '@angular/http'
import 'rxjs/add/operator/map';
import {Pokemon} from "../entities/pokemon";
import 'rxjs/add/operator/debounceTime';

@Injectable()
export class SightingsService {
	constructor(public http: Http) {}

	findPokemonInView(latitude:number, longitude:number, zoom:number = 20, pokemon:Pokemon) {
		return this.http.get("http://192.168.1.8:8080/sightings?latitude=" + latitude + "&longitude=" + longitude + "&distance=" + zoom*0.1 + "&pokemon_id=" + pokemon.id)
			.map(response => response.text());
	}

}
