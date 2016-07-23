export class Pokemon {
	id: number
	name: string
	rarity: string
	number: number

	constructor(id: number, name: string, rarity: string, number: number) {
		this.id = id;
		this.name = name;
		this.rarity = rarity;
		this.number = number;
	}
}
