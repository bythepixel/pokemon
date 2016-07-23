import {Injectable} from '@angular/core';
import {Http, Headers} from '@angular/http'
import {Observable} from 'rxjs/Observable';
import {Pokemon} from '../entities/pokemon';
import {BehaviorSubject} from 'rxjs/BehaviorSubject';
import 'rxjs/add/operator/map';

@Injectable()
export class PokemonStateService {
	public activePokemon: BehaviorSubject<Pokemon> = new BehaviorSubject<Pokemon>(new Pokemon(0, null, null, null));

	private data;

  setActive(pokemon:Pokemon) {
		this.activePokemon.next(pokemon);
  }

}
