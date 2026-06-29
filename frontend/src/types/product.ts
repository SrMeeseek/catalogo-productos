export interface PaginatedProducts {
  data: Product[];
  current_page: number;
  last_page: number;
  total: number;
}

export interface Brand {
  id: number;
  name: string;
}

export interface Product {
  id: number;
  name: string;
  unit: "Unidad" | "Display" | "Caja";
  observations: string;
  price: number;
  brand: Brand;
  image: string | null;
}
