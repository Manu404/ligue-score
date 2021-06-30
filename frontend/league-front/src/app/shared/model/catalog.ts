export interface Player {
    id: number;
    name: string;
}

export interface Item {
    id: number;
    name: string;
    detail: string;
    cost: number;
}
export interface Rule {
    id: number;
    name: string;
    detail: string;
    delta: number;
}
export interface Gameday {
    id: number;
    date: Date;
}
export interface GammeType {
    id: number;
    name: string;
}
export interface Catalog {
    days: Gameday[];
    types: GammeType[];
    players: Player[];
    rules: Rule[];
    items: Item[];
}
export interface GetCatalogResponse {
    status: number;
    message: string;
    result: Catalog;
}