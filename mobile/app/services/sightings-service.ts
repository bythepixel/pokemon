import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';

@Injectable()
export class SightingsService {

    findAll() {

        return Observable.create(observer => {
            observer.next(`{
												    "4": {
												        "sightings": [
												            {
												                "latitude": 39.8677588,
												                "longitude": -105.067
												            },
												            {
												                "latitude": 39.86777,
												                "longitude": -105.067
												            }
												        ]
												    }
												}`);
            observer.complete();
        });

    }

}
