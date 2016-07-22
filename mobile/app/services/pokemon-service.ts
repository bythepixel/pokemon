import {Injectable} from '@angular/core';
import {Http, Headers} from '@angular/http'
import {Observable} from 'rxjs/Observable';
import 'rxjs/add/operator/map';

@Injectable()
export class PokemonService {

	private data;

	constructor(public http: Http) {

	}

    findAll() {

			return this.http.get('http://api.pokemon.local/pokemon')
			  .map(response => response.text());

    }

}
