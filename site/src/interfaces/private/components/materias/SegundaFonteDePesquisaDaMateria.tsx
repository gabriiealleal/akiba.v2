import { useParams } from 'react-router-dom';
import { usePost } from '@/services/posts/queries';

const PrimeiraFonteDePesquisaDaMateria = () => {
    const { slug } = useParams();
    const { data: getPost } = usePost(slug ?? "");
    const postagem = getPost?.publicação;

    return (
        <div className='flex flex-col gap-2'>
            <span className='font-averta font-extrabold text-laranja text-lg uppercase text-center italic'>Segunda fonte de pesquisa</span>
            <div className='flex items-center gap-4 -mt-1'>
                <label htmlFor="segunda_fonte_nome" className='font-averta font-regular text-laranja text-lg uppercase'>Nome</label>
                <input id="segunda_fonte_nome" name="segunda_fonte_nome" type='text' className='w-full rounded-md p-2 font-averta appearance-none pr-8 outline-none' defaultValue={postagem?.search_fonts?.[1]?.site}/>
            </div>
            <div className='flex items-center gap-7 mt-1'>
                <label htmlFor="segunda_fonte_link" className='font-averta font-regular text-laranja text-lg uppercase'>Link</label>
                <input id="segunda_fonte_link" name="segunda_fonte_link "type='url' className='w-full rounded-md p-2 font-averta appearance-none pr-8 outline-none'  defaultValue={postagem?.search_fonts?.[1]?.endereco}/>
            </div>
        </div>
    );
}

export default PrimeiraFonteDePesquisaDaMateria;