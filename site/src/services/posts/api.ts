import axios from 'axios';
import { PostTypes } from '@/services/posts/types.ts';

export const getPosts = async () => {
    try{
        const response = await axios.get(`${import.meta.env.VITE_API_ADDRESS}/postagens`, {
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('akb_token')}`,
            }
        });
        return response.data;
    }catch(error: any){
        throw error.response;
    }
}

export const getPost = async (slug: string) => {
    try{
        const response = await axios.get(`${import.meta.env.VITE_API_ADDRESS}/postagens/${slug}`, {
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('akb_token')}`,
            }
        });
        return response.data;
    }catch(error: any){
        throw error.response;
    }
}

export const updatePost = async (id: number, data: PostTypes) => {
    console.log(data)
    try{
        const response = await axios.patch(`${import.meta.env.VITE_API_ADDRESS}/postagens/${id}`, data, {
            headers: {
                'Accept': 'multipart/form-data',
                'Authorization': `Bearer ${localStorage.getItem('akb_token')}`,
            }
        });
        return response.data;
    }catch(error: any){
        throw error.response;
    }
}