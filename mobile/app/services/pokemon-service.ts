import {Injectable} from '@angular/core';
import {Http, Headers} from '@angular/http'
import {Observable} from 'rxjs/Observable';
import 'rxjs/add/operator/map';
import {EnvironmentService} from './environment-service';

@Injectable()
export class PokemonService {

	private data;

	constructor(public http: Http, public environmentService: EnvironmentService) {}

	findAll() {
		return this.http.get(this.environmentService.API_IP + '/pokemon')
			.map(response => response.text());
	}

}
