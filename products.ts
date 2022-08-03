export interface Product {
  id: number;
  name: string;
  price: number;
  description: string;
}

export const products: Product[] = [
  {
    id: 1,
    name: 'Phone XL',
    price: 799,
    description: 'Product 1'
  },
  {
    id: 2,
    name: 'Phone Mini',
    price: 699,
    description: 'Product 2'
  },
  {
    id: 3,
    name: 'Phone Standard',
    price: 299,
    description: 'Product 3'
  }
];
