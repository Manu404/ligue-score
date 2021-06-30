export interface GeneralRanking {
    rank: number;
    name: string;
    score: number;
  }

  export interface GetGeneralRankingResponse {
    status: number;
    message: string;
    result: GeneralRanking[];
  }