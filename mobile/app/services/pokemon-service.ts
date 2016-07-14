import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';

@Injectable()
export class PokemonService {

    findAll() {

        return Observable.create(observer => {
            observer.next(`[
    {
        "name": "Bulbasaur",
        "rarity": "common",
        "number": "1"
    },
    {
        "name": "Ivysaur",
        "rarity": "common",
        "number": "2"
    }
]`);
            observer.complete();
        });

    }

}
