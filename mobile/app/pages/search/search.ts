import {Component, Output, AfterViewChecked, EventEmitter} from '@angular/core';
import {NavController} from 'ionic-angular';
import {PokemonService} from '../../services/pokemon-service';
import {PokemonStateService} from '../../services/pokemon-state-service'
import {Pokemon} from '../../entities/pokemon';
import {HomePage} from '../home/home';

@Component({
  templateUrl: 'build/pages/search/search.html'
})
export class SearchPage {

	@Output() activePokemon = new EventEmitter();
	pokemons: Pokemon[]
	searchQuery: string
	pokemonsFiltered = []

  constructor(private navController: NavController, private pokemonService:PokemonService, private pokemonStateService:PokemonStateService) {
    this.searchQuery = '';
		this.pokemons = [];

		this.pokemonService.findAll().subscribe((pokemons) => {
			let pokemonsObject = JSON.parse(pokemons);
			pokemonsObject.forEach((pokemon) => {
				let newPokemon = new Pokemon(pokemon['id'], pokemon['name'], pokemon['rarity'], pokemon['number']);
				this.pokemons.push(newPokemon);
			});
		});

		this.initializeItems();
  }

	initializeItems() {
		this.pokemonsFiltered = this.pokemons;
  }

	getItems(event) {
    // Reset items back to all of the items
    this.initializeItems();

    // set val to the value of the searchbar
    let value = event.target.value;

   // if the value is an empty string don't filter the items
    if (value && value.trim() != '') {
      this.pokemonsFiltered = this.pokemonsFiltered.filter((item) => {
        return (item.toLowerCase().indexOf(value.toLowerCase()) > -1);
      });
    }
  }

	selectPokemon(pokemon: Pokemon) {
		this.pokemonStateService.setActive(pokemon);
		this.navController.push(HomePage);
	}
}
