export interface GeneralRanking {
    rank: number;
    id: number;
    score: number;
  }

  export interface GetGeneralRankingResponse {
    status: number;
    message: string;
    result: GeneralRanking[];
  }