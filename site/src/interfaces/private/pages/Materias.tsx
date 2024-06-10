import { useState } from 'react';
import { useParams } from 'react-router-dom';
import { toast } from 'react-toastify';
import usePageName from '@/hooks/usePageName';
import { usePost } from '@/services/posts/queries';
import { useUpdatePost } from '@/services/posts/mutations';
import DivisorDeTiposDeMaterias from '@/interfaces/private/components/materias/DivisorDeTiposDeMaterias';
import ImagemEmDestaqueDaMateria from '@/interfaces/private/components/materias/ImagemEmDestaqueDaMateria';
import TituloDaMateria from '@/interfaces/private/components/materias/TituloDaMateria';
import CapaDaMateria from '@/interfaces/private/components/materias/CapaDaMateria';
import EscrevaSuaMateria from '@/interfaces/private/components/materias/EscrevaSuaMateria';
import PrimeiraTagDaMateria from '@/interfaces/private/components/materias/PrimeiraTagDaMateria';
import SegundaTagDaMateria from '@/interfaces/private/components/materias/SegundaTagDaMateria';
import PrimeiraFonteDePesquisaDaMateria from '@/interfaces/private/components/materias/PrimeiraFonteDePesquisaDaMateria';
import SegundaFonteDePesquisaDaMateria from '@/interfaces/private/components/materias/SegundaFonteDePesquisaDaMateria';
import ControlesDePublicacaoDaMateria from '@/interfaces/private/components/materias/ControlesDePublicacaoDaMateria';

const Materias = () => {
    const [materia, setMateria] = useState('' as string); console.log(materia)
    const pageName = usePageName;

    const { slug } = useParams();
    const { data: getPost } = usePost(slug ?? "");
    const { mutate: updatePost } = useUpdatePost(getPost?.publicação?.id, ()=>{
        toast.success("Matéria atualizada com sucesso!")
    });
    
    const onSubmit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        const data = new FormData(event.currentTarget);
        console.log(data.get('titulo') as string);
        updatePost({
            author: getPost?.publicação?.author as number,
            featured_image: (data.getAll('imagem_em_destaque')[0] as File),
            image: (data.getAll('capa_da_materia')[0] as File),
            title: data.get('titulo') as string,
            content: materia,
            categories: [data.get('primeira_tag') as string, data.get('segunda_tag') as string],
            search_fonts: [
                {
                    site: data.get('primeira_fonte') as string,
                    endereco: data.get('primeira_fonte_endereco') as string,
                },
                {
                    site: data.get('segunda_fonte') as string,
                    endereco: data.get('segunda_fonte_endereco') as string,
                }
            ]
        });
    };

    pageName('Matérias');
    return (
        <>
            <DivisorDeTiposDeMaterias />
            <form onSubmit={onSubmit}>
                <div className="flex gap-4 mt-5 flex-wrap sm:flex-nowrap">
                    <div className='w-full sm:w-56 md:w-64 p-0 m-0 flex-shrink-0'>
                        <ImagemEmDestaqueDaMateria/>
                    </div>
                    <div className='flex-grow'>
                        <TituloDaMateria />
                        <CapaDaMateria />
                        <EscrevaSuaMateria setMateria={setMateria}/>
                    </div>
                </div>
                <div className="flex justify-end flex-wrap sm:flex-nowrap gap-5 xl:gap-14 mt-5">
                    <div className='w-full xl:w-32rem p-0 m-0 flex-shrink-1 xl:flex-shrink-0'>
                        <PrimeiraTagDaMateria />
                    </div>
                    <div className='w-full xl:w-32rem p-0 m-0 flex-shrink-1 xl:flex-shrink-0'>
                        <SegundaTagDaMateria />
                    </div>
                </div>
                <div className="flex justify-end flex-wrap sm:flex-nowrap gap-5 xl:gap-14 mt-5">
                    <div className='w-full xl:w-32rem p-0 m-0 flex-shrink-1 xl:flex-shrink-0'>
                        <PrimeiraFonteDePesquisaDaMateria />
                    </div>
                    <div className='w-full xl:w-32rem p-0 m-0 flex-shrink-1 xl:flex-shrink-0'>
                        <SegundaFonteDePesquisaDaMateria />
                    </div>
                </div>
                <ControlesDePublicacaoDaMateria />
            </form>
        </>
    );
}

export default Materias;
