export interface PostTypes {
    author?: number,
    featured_image?: File,
    image?: File,
    title?: string,
    content?: string,
    categories?: string[],
    search_fonts?: { site: string, endereco: string }[],
} 